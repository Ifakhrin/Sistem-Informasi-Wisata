<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\SavedPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDestinasi = Destinasi::count();
        $totalKategori = Destinasi::distinct('kategori')->count('kategori');

        $totalSavedPlans = SavedPlan::where('user_id', Auth::id())->count();

        $destinasiTerbaik = Destinasi::orderByDesc('rating')->first();

        $aiRecommendations = Destinasi::orderByDesc('rating')
            ->limit(3)
            ->get();

        $userTravelScore = min(100, 50 + ($totalSavedPlans * 10));

        $kategoriTrending = Destinasi::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->limit(4)
            ->get();

        $activityLabels = [];
        $activityData = [];
        $recentDestinasi = Destinasi::latest()
            ->limit(3)
            ->get();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $activityLabels[] = $date->format('d M');

            $activityData[] = SavedPlan::where('user_id', Auth::id())
                ->whereDate('created_at', $date->toDateString())
                ->count();
}
        return view('dashboard', compact(
            'totalDestinasi',
            'totalKategori',
            'totalSavedPlans',
            'destinasiTerbaik',
            'userTravelScore',
            'kategoriTrending',
            'activityLabels',
            'activityData',
            'recentDestinasi',
            'aiRecommendations'
        ));
    }
}