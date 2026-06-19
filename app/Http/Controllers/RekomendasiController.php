<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\SavedPlan;
use App\Models\TourismRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    public function index()
    {
        $kategoris = Destinasi::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $rekomendasis = collect();

        $savedDestinasiIds = SavedPlan::where('user_id', Auth::id())
            ->pluck('destinasi_id')
            ->toArray();

        $selectedKategori = null;
        $selectedBudget = null;

        return view('rekomendasi.index', compact(
            'kategoris',
            'rekomendasis',
            'savedDestinasiIds',
            'selectedKategori',
            'selectedBudget'
        ));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'kategori' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $selectedKategori = $request->kategori;
        $selectedBudget = $request->budget;

        $destinasis = Destinasi::query()->get();

        $ratingStats = TourismRating::select(
                'place_id',
                DB::raw('AVG(place_rating) as average_rating'),
                DB::raw('COUNT(*) as total_rating')
            )
            ->groupBy('place_id')
            ->get()
            ->keyBy('place_id');

        $maxTotalRating = max(1, (int) ($ratingStats->max('total_rating') ?? 1));

        $rekomendasis = $destinasis->map(function ($destinasi) use ($selectedKategori, $selectedBudget, $ratingStats, $maxTotalRating) {
            $score = 0;

            $stat = $ratingStats->get($destinasi->place_id);

            $averageRating = $stat ? (float) $stat->average_rating : (float) $destinasi->rating;
            $totalRating = $stat ? (int) $stat->total_rating : 0;

            /*
            |--------------------------------------------------------------------------
            | 1. Preference Match Score
            |--------------------------------------------------------------------------
            | Kategori yang cocok diberi bobot besar karena ini preferensi utama user.
            */
            if ($selectedKategori && $destinasi->kategori === $selectedKategori) {
                $score += 40;
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Budget Match Score
            |--------------------------------------------------------------------------
            | Destinasi dengan harga tiket <= budget diberi skor tambahan.
            */
            if ($selectedBudget !== null && $selectedBudget !== '') {
                if ($destinasi->harga_tiket <= $selectedBudget) {
                    $score += 25;
                } else {
                    $score -= 20;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Dataset Average Rating Score
            |--------------------------------------------------------------------------
            | Rata-rata rating dari tourism_rating.csv dinormalisasi ke maksimal 20.
            */
            $ratingScore = min(20, ($averageRating / 5) * 20);
            $score += $ratingScore;

            /*
            |--------------------------------------------------------------------------
            | 4. Popularity Score
            |--------------------------------------------------------------------------
            | Total rating menggambarkan popularitas destinasi.
            | Semakin banyak dinilai user dataset, semakin tinggi skornya.
            */
            $popularityScore = ($totalRating / $maxTotalRating) * 15;
            $score += $popularityScore;

            $destinasi->dataset_average_rating = round($averageRating, 2);
            $destinasi->dataset_total_rating = $totalRating;
            $destinasi->recommendation_score = max(0, round($score));

            return $destinasi;
        })
        ->filter(function ($destinasi) {
            return $destinasi->recommendation_score > 0;
        })
        ->sortByDesc('recommendation_score')
        ->values();

        $kategoris = Destinasi::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $savedDestinasiIds = SavedPlan::where('user_id', Auth::id())
            ->pluck('destinasi_id')
            ->toArray();

        return view('rekomendasi.index', compact(
            'kategoris',
            'rekomendasis',
            'savedDestinasiIds',
            'selectedKategori',
            'selectedBudget'
        ));
    }
}