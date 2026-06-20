<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class AdminImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        if (!$file) {
            return redirect()
                ->route('import.index')
                ->with('error', 'File gagal dibaca.');
        }

        $header = fgetcsv($file);

        if (!$header) {
            fclose($file);

            return redirect()
                ->route('import.index')
                ->with('error', 'File CSV kosong atau format tidak valid.');
        }

        $normalizedHeader = array_map(function ($item) {
            return strtolower(trim($item));
        }, $header);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($file)) !== false) {
            $data = $this->combineCsvRow($normalizedHeader, $row);

            $placeId = $this->getCsvValue($data, $row, ['place_id', 'placeid', 'id'], 0);
            $namaWisata = $this->getCsvValue($data, $row, ['place_name', 'placename', 'nama_wisata', 'nama wisata'], 1);
            $deskripsi = $this->getCsvValue($data, $row, ['description', 'deskripsi'], 2);
            $kategori = $this->getCsvValue($data, $row, ['category', 'kategori'], 3);
            $kota = $this->getCsvValue($data, $row, ['city', 'kota'], 4);
            $hargaTiket = $this->getCsvValue($data, $row, ['price', 'harga_tiket', 'harga tiket'], 5);
            $rating = $this->getCsvValue($data, $row, ['rating'], 6);
            $timeMinutes = $this->getCsvValue($data, $row, ['time_minutes', 'time minutes', 'durasi'], 7);
            $latitude = $this->getCsvValue($data, $row, ['lat', 'latitude'], 9);
            $longitude = $this->getCsvValue($data, $row, ['long', 'longitude', 'lng'], 10);

            if (!$namaWisata || !$kategori || !$kota) {
                $skipped++;
                continue;
            }

            $hargaTiket = is_numeric($hargaTiket) ? max(0, (int) $hargaTiket) : 0;
            $rating = is_numeric($rating) ? min(5, max(0, (float) $rating)) : 0;
            $timeMinutes = is_numeric($timeMinutes) ? max(0, (int) $timeMinutes) : null;
            $latitude = is_numeric($latitude) ? $latitude : null;
            $longitude = is_numeric($longitude) ? $longitude : null;
            $placeId = is_numeric($placeId) ? (int) $placeId : null;

            $payload = [
                'place_id'     => $placeId,
                'nama_wisata'  => $namaWisata,
                'kategori'     => $kategori,
                'kota'         => $kota,
                'provinsi'     => $this->provinceFromCity($kota),
                'rating'       => $rating,
                'harga_tiket'  => $hargaTiket,
                'time_minutes' => $timeMinutes,
                'latitude'     => $latitude,
                'longitude'    => $longitude,
                'deskripsi'    => $deskripsi,
                'gambar'       => null,
            ];

            if ($placeId) {
                Destinasi::updateOrCreate(
                    ['place_id' => $placeId],
                    $payload
                );
            } else {
                Destinasi::create($payload);
            }

            $imported++;
        }

        fclose($file);

        return redirect()
            ->route('destinations.index')
            ->with('success', "Berhasil mengimpor {$imported} data destinasi. Data dilewati: {$skipped}.");
    }

    private function combineCsvRow(array $header, array $row): array
    {
        $data = [];

        foreach ($header as $index => $key) {
            $data[$key] = $row[$index] ?? null;
        }

        return $data;
    }

    private function getCsvValue(array $data, array $row, array $possibleKeys, int $fallbackIndex): mixed
    {
        foreach ($possibleKeys as $key) {
            $normalizedKey = strtolower(trim($key));

            if (array_key_exists($normalizedKey, $data)) {
                return $data[$normalizedKey];
            }
        }

        return $row[$fallbackIndex] ?? null;
    }

    private function provinceFromCity(?string $city): string
    {
        return match (strtolower(trim($city ?? ''))) {
            'jakarta' => 'DKI Jakarta',
            'yogyakarta' => 'DI Yogyakarta',
            'bandung' => 'Jawa Barat',
            'semarang' => 'Jawa Tengah',
            'surabaya' => 'Jawa Timur',
            default => 'Tidak Diketahui',
        };
    }
}
