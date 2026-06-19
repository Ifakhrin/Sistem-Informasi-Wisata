<?php

namespace App\Services;

use App\Models\Destinasi;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GroqService
{
    public function test(): string
    {
        return 'GroqService berhasil dipanggil';
    }

    public function chat(string $message): string
    {
        $apiKey = config('services.groq.api_key');
        $baseUrl = rtrim(config('services.groq.base_url'), '/');
        $model = config('services.groq.model');

        if (!$apiKey) {
            throw new RuntimeException('Groq API key belum tersedia.');
        }

        $query = Destinasi::query();
        $messageLower = strtolower($message);
        $normalizedMessage = $this->normalizeText($message);

        /*
        |--------------------------------------------------------------------------
        | Deteksi kategori dari dataset
        |--------------------------------------------------------------------------
        */
        $kategoriList = Destinasi::select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();

        $kategoriTerdeteksi = [];

        foreach ($kategoriList as $kategori) {
            if (str_contains($normalizedMessage, $this->normalizeText($kategori))) {
                $kategoriTerdeteksi[] = $kategori;
            }
        }

        if (!empty($kategoriTerdeteksi)) {
            $query->whereIn('kategori', $kategoriTerdeteksi);
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi kota dan provinsi berbasis dataset
        |--------------------------------------------------------------------------
        */
        $kotaList = Destinasi::select('kota')
            ->distinct()
            ->pluck('kota')
            ->filter()
            ->values();

        $provinsiList = Destinasi::select('provinsi')
            ->distinct()
            ->pluck('provinsi')
            ->filter()
            ->values();

        $availableLocations = $kotaList
            ->merge($provinsiList)
            ->unique()
            ->values()
            ->toArray();

        $kotaTerdeteksi = [];
        $provinsiTerdeteksi = [];
        $lokasiTidakTersedia = [];
        $locationCorrectionNote = null;

        foreach ($kotaList as $kota) {
            if (str_contains($normalizedMessage, $this->normalizeText($kota))) {
                $kotaTerdeteksi[] = $kota;
            }
        }

        foreach ($provinsiList as $provinsi) {
            if (str_contains($normalizedMessage, $this->normalizeText($provinsi))) {
                $provinsiTerdeteksi[] = $provinsi;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi lokasi eksplisit dan typo lokasi
        |--------------------------------------------------------------------------
        | Catatan:
        | - masjid, pantai, gunung, kebun, museum tidak langsung dianggap lokasi.
        | - Jika kata ada di nama/deskripsi/kategori destinasi, maka diproses
        |   sebagai keyword tematik.
        | - Typo lokasi seperti "bandng" tetap bisa dikoreksi ke "Bandung".
        */
        $requestedLocationText = $this->extractRequestedLocation($message);

        if (!$requestedLocationText) {
            $shortQueryTokens = explode(' ', $normalizedMessage);

            if (count($shortQueryTokens) <= 2) {
                $isDestinationKeyword = $this->keywordExistsInDestinasi($normalizedMessage);

                if (!$isDestinationKeyword) {
                    $possibleLocation = $this->findClosestLocation($normalizedMessage, $availableLocations);

                    if ($possibleLocation) {
                        $requestedLocationText = $normalizedMessage;
                    }
                }
            }
        }

        if ($requestedLocationText) {
            $requestedLocations = preg_split('/\s+(?:dan|atau)\s+|,|\/|&/i', $requestedLocationText);

            foreach ($requestedLocations as $requestedLocation) {
                $requestedLocation = trim($requestedLocation);

                $requestedLocation = preg_replace(
                    '/\b(wisata|tempat|destinasi|rekomendasi|cari|carikan|murah|gratis|hemat|keluarga|alam|budaya|sejarah|religi|kuliner|yang|di|ke|untuk|dan|atau)\b/i',
                    '',
                    $requestedLocation
                );

                $requestedLocation = trim(preg_replace('/\s+/', ' ', $requestedLocation));

                if ($requestedLocation === '') {
                    continue;
                }

                $closestLocation = $this->findClosestLocation($requestedLocation, $availableLocations);

                if ($closestLocation) {
                    if ($this->normalizeText($requestedLocation) !== $this->normalizeText($closestLocation)) {
                        $locationCorrectionNote = "Catatan: Input lokasi '{$requestedLocation}' ditafsirkan sebagai '{$closestLocation}' berdasarkan kemiripan dengan data sistem.";
                    }

                    if ($kotaList->contains($closestLocation)) {
                        $kotaTerdeteksi[] = $closestLocation;
                    }

                    if ($provinsiList->contains($closestLocation)) {
                        $provinsiTerdeteksi[] = $closestLocation;
                    }
                } else {
                    if (!$this->keywordExistsInDestinasi($requestedLocation)) {
                        $lokasiTidakTersedia[] = ucwords($requestedLocation);
                    }
                }
            }
        }

        $kotaTerdeteksi = array_values(array_unique($kotaTerdeteksi));
        $provinsiTerdeteksi = array_values(array_unique($provinsiTerdeteksi));
        $lokasiTidakTersedia = array_values(array_unique($lokasiTidakTersedia));

        /*
        |--------------------------------------------------------------------------
        | Terapkan filter lokasi
        |--------------------------------------------------------------------------
        */
        if (!empty($kotaTerdeteksi) || !empty($provinsiTerdeteksi)) {
            $query->where(function ($q) use ($kotaTerdeteksi, $provinsiTerdeteksi) {
                if (!empty($kotaTerdeteksi)) {
                    $q->whereIn('kota', $kotaTerdeteksi);
                }

                if (!empty($provinsiTerdeteksi)) {
                    $q->orWhereIn('provinsi', $provinsiTerdeteksi);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Jika user hanya meminta lokasi yang tidak tersedia
        |--------------------------------------------------------------------------
        */
        if (empty($kotaTerdeteksi) && empty($provinsiTerdeteksi) && !empty($lokasiTidakTersedia)) {
            $availableLocationText = $kotaList->implode(', ');

            return "Maaf, data destinasi untuk " . implode(', ', $lokasiTidakTersedia) . " belum tersedia dalam dataset sistem. Lokasi yang tersedia dalam dataset saat ini adalah: {$availableLocationText}.";
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi budget angka
        |--------------------------------------------------------------------------
        */
        $budgetInfo = "Budget pengguna tidak disebutkan.";

        $messageAngka = str_replace(['.', ','], '', $message);

        if (preg_match('/\b(\d{4,})\b/', $messageAngka, $matches)) {
            $budget = (int) $matches[1];

            $query->where('harga_tiket', '<=', $budget);

            $budgetInfo = "Budget pengguna: Rp " . number_format($budget, 0, ',', '.');
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi intent murah/gratis
        |--------------------------------------------------------------------------
        */
        $cheapIntent = str_contains($messageLower, 'murah')
            || str_contains($messageLower, 'gratis')
            || str_contains($messageLower, 'hemat')
            || str_contains($messageLower, 'low budget')
            || str_contains($messageLower, 'terjangkau');

        /*
        |--------------------------------------------------------------------------
        | Deteksi keyword tematik dari input user
        |--------------------------------------------------------------------------
        | Keyword dicari langsung ke database, bukan hardcode.
        */
        $stopwords = [
            'aku', 'saya', 'tolong', 'dong', 'nih', 'aja',
            'carikan', 'cari', 'rekomendasi', 'tempat', 'destinasi',
            'wisata', 'yang', 'dan', 'atau', 'di', 'ke', 'dari', 'untuk',
            'dengan', 'keren', 'bagus', 'menarik', 'cocok', 'paling',
            'murah', 'gratis', 'hemat', 'budget', 'biaya', 'harga',
            'keluarga', 'anak', 'pasangan', 'solo', 'traveler', 'ok'
        ];

        $keywordCandidates = collect(explode(' ', $normalizedMessage))
            ->filter(function ($word) use ($stopwords) {
                return strlen($word) >= 4 && !in_array($word, $stopwords);
            })
            ->unique()
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Hapus keyword yang merupakan lokasi atau typo lokasi
        |--------------------------------------------------------------------------
        */
        $detectedLocations = array_merge($kotaTerdeteksi, $provinsiTerdeteksi);

        $keywordCandidates = collect($keywordCandidates)
            ->reject(function ($keyword) use ($detectedLocations) {
                foreach ($detectedLocations as $location) {
                    $normalizedKeyword = $this->normalizeText($keyword);
                    $normalizedLocation = $this->normalizeText($location);

                    if (
                        str_contains($normalizedLocation, $normalizedKeyword) ||
                        str_contains($normalizedKeyword, $normalizedLocation)
                    ) {
                        return true;
                    }

                    similar_text($normalizedKeyword, $normalizedLocation, $percent);

                    $levenshteinDistance = levenshtein($normalizedKeyword, $normalizedLocation);
                    $maxLength = max(strlen($normalizedKeyword), strlen($normalizedLocation));

                    $levenshteinScore = $maxLength > 0
                        ? (1 - ($levenshteinDistance / $maxLength)) * 100
                        : 0;

                    $score = max($percent, $levenshteinScore);

                    if ($score >= 70) {
                        return true;
                    }
                }

                return false;
            })
            ->values()
            ->toArray();

        if (!empty($keywordCandidates)) {
            $query->where(function ($q) use ($keywordCandidates) {
                foreach ($keywordCandidates as $keyword) {
                    $q->orWhere('nama_wisata', 'like', '%' . $keyword . '%')
                        ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                        ->orWhere('kategori', 'like', '%' . $keyword . '%')
                        ->orWhere('kota', 'like', '%' . $keyword . '%')
                        ->orWhere('provinsi', 'like', '%' . $keyword . '%');
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data destinasi
        |--------------------------------------------------------------------------
        */
        if ($cheapIntent) {
            $query->orderBy('harga_tiket')->orderByDesc('rating');
        } else {
            $query->orderByDesc('rating');
        }

        $destinasi = $query
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Fallback keyword search
        |--------------------------------------------------------------------------
        */
        if (
            $destinasi->isEmpty()
            && !empty($keywordCandidates)
            && empty($kotaTerdeteksi)
            && empty($provinsiTerdeteksi)
            && empty($lokasiTidakTersedia)
        ) {
            $fallbackQuery = Destinasi::query();

            $fallbackQuery->where(function ($q) use ($keywordCandidates) {
                foreach ($keywordCandidates as $keyword) {
                    $q->orWhere('nama_wisata', 'like', '%' . $keyword . '%')
                        ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                        ->orWhere('kategori', 'like', '%' . $keyword . '%')
                        ->orWhere('kota', 'like', '%' . $keyword . '%')
                        ->orWhere('provinsi', 'like', '%' . $keyword . '%');
                }
            });

            if ($cheapIntent) {
                $fallbackQuery->orderBy('harga_tiket')->orderByDesc('rating');
            } else {
                $fallbackQuery->orderByDesc('rating');
            }

            $destinasi = $fallbackQuery
                ->limit(10)
                ->get();
        }

        if ($destinasi->isEmpty()) {
            $pesan = "Maaf, tidak ditemukan destinasi yang sesuai dengan kriteria yang diberikan.";

            if (!empty($lokasiTidakTersedia)) {
                $pesan .= " Data untuk " . implode(', ', $lokasiTidakTersedia) . " belum tersedia dalam dataset sistem.";
            }

            if (!empty($keywordCandidates)) {
                $pesan .= " Kata kunci yang dicari: " . implode(', ', $keywordCandidates) . ".";
            }

            return $pesan;
        }

        /*
        |--------------------------------------------------------------------------
        | Buat konteks untuk AI
        |--------------------------------------------------------------------------
        */
        $context = $budgetInfo . "\n\n";

        if ($cheapIntent) {
            $context .= "Preferensi pengguna: mencari destinasi murah/hemat. Prioritaskan destinasi dengan harga tiket paling rendah.\n\n";
        }

        if (!empty($keywordCandidates)) {
            $context .= "Keyword tematik pengguna: " . implode(', ', $keywordCandidates) . ". Gunakan keyword ini untuk menjelaskan alasan kecocokan destinasi.\n\n";
        }

        if ($locationCorrectionNote) {
            $context .= $locationCorrectionNote . "\n\n";
        }

        if (!empty($lokasiTidakTersedia)) {
            $context .= "Catatan penting: Data untuk " . implode(', ', $lokasiTidakTersedia) . " belum tersedia dalam sistem. Jangan memberikan rekomendasi untuk lokasi tersebut.\n\n";
        }

        $context .= "Data destinasi wisata yang tersedia dalam sistem:\n\n";

        foreach ($destinasi as $item) {
            $hargaTiket = $item->harga_tiket == 0
                ? 'Gratis'
                : 'Rp ' . number_format($item->harga_tiket, 0, ',', '.');

            $context .=
                "Nama: {$item->nama_wisata}\n" .
                "Kategori: {$item->kategori}\n" .
                "Kota: {$item->kota}\n" .
                "Provinsi: {$item->provinsi}\n" .
                "Rating: {$item->rating}\n" .
                "Harga Tiket: {$hargaTiket}\n" .
                "Durasi Kunjungan: " . ($item->time_minutes ? $item->time_minutes . ' menit' : 'Tidak tersedia') . "\n" .
                "Deskripsi: " . \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 350) . "\n\n";
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(60)
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "Kamu adalah AI Assistant untuk aplikasi rekomendasi destinasi wisata Indonesia.

Gunakan hanya data destinasi berikut sebagai referensi utama:

$context

Aturan:
- Jawab selalu dalam bahasa Indonesia.
- HANYA gunakan destinasi yang terdapat pada data sistem.
- DILARANG menambahkan destinasi dari pengetahuan umum.
- Jika user meminta lokasi yang tidak tersedia dalam data sistem, jelaskan bahwa data lokasi tersebut belum tersedia.
- Jangan mengarang nama destinasi, lokasi, harga tiket, aktivitas, atau rating.
- Jika data hanya cocok untuk satu kota, jangan menyebut kota lain.
- Jika harga tiket adalah Gratis, tulis Estimasi budget: Gratis.
- Jangan menulis Estimasi budget: Rp 0.
- Jika harga tiket berupa angka, tulis sesuai data sistem.
- Budget pengguna hanya dipakai untuk menyaring destinasi, bukan untuk mengganti harga tiket.
- Jika pengguna meminta wisata murah, prioritaskan dan jelaskan destinasi dengan harga tiket paling rendah dari data sistem.
- Jika pengguna menyebut keyword seperti pantai, gunung, museum, taman, kebun, masjid, kuliner, air terjun, atau sejarah, rekomendasi harus relevan dengan keyword tersebut berdasarkan nama, kategori, atau deskripsi data sistem.
- Jangan gunakan markdown.
- Jangan gunakan tanda bintang.
- Jangan gunakan tabel.
- Jangan menulis semua jawaban dalam satu paragraf.
- Jika ada catatan koreksi lokasi, sebutkan secara singkat di awal jawaban.
- Jika sebagian lokasi tersedia dan sebagian tidak tersedia, jelaskan lokasi yang tidak tersedia, lalu berikan rekomendasi hanya untuk lokasi yang tersedia.

Jika pengguna meminta rekomendasi destinasi, gunakan format berikut:

1. Nama Destinasi
Lokasi: Kota, Provinsi
Alasan cocok: ...
Estimasi budget: ...
Aktivitas: ...

Maksimal berikan 3 rekomendasi kecuali pengguna meminta jumlah lain.",
                    ],
                    [
                        'role' => 'user',
                        'content' => $message,
                    ],
                ],
                'temperature' => 0.2,
                'max_tokens' => 600,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Groq API error: ' . $response->status() . ' - ' . $response->body()
            );
        }

        return $response->json('choices.0.message.content') ?? 'Maaf, AI belum dapat memberikan jawaban.';
    }

    private function normalizeText(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    private function findClosestLocation(string $input, array $availableLocations): ?string
    {
        $input = $this->normalizeText($input);

        if ($input === '') {
            return null;
        }

        $bestMatch = null;
        $bestScore = 0;

        foreach ($availableLocations as $location) {
            $normalizedLocation = $this->normalizeText($location);

            if ($normalizedLocation === '') {
                continue;
            }

            if ($input === $normalizedLocation) {
                return $location;
            }

            similar_text($input, $normalizedLocation, $percent);

            $levenshteinDistance = levenshtein($input, $normalizedLocation);
            $maxLength = max(strlen($input), strlen($normalizedLocation));

            $levenshteinScore = $maxLength > 0
                ? (1 - ($levenshteinDistance / $maxLength)) * 100
                : 0;

            $score = max($percent, $levenshteinScore);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $location;
            }
        }

        return $bestScore >= 75 ? $bestMatch : null;
    }

    private function extractRequestedLocation(string $message): ?string
    {
        $message = $this->normalizeText($message);

        $patterns = [
            '/\bwisata\s+di\s+([a-z\s]+)/',
            '/\brekomendasi\s+wisata\s+di\s+([a-z\s]+)/',
            '/\btempat\s+wisata\s+di\s+([a-z\s]+)/',
            '/\bdi\s+([a-z\s]+)$/',
            '/\bke\s+([a-z\s]+)$/',
            '/\bdaerah\s+([a-z\s]+)$/',
            '/\bkota\s+([a-z\s]+)$/',
            '/\bprovinsi\s+([a-z\s]+)$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                return trim($matches[1]);
            }
        }

        return null;
    }

    private function keywordExistsInDestinasi(string $keyword): bool
    {
        return Destinasi::where('nama_wisata', 'like', '%' . $keyword . '%')
            ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
            ->orWhere('kategori', 'like', '%' . $keyword . '%')
            ->orWhere('kota', 'like', '%' . $keyword . '%')
            ->orWhere('provinsi', 'like', '%' . $keyword . '%')
            ->exists();
    }
}