<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\SavedPlanController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\AdminDestinationController;
use App\Http\Controllers\AdminImportController;
use App\Models\Destinasi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome', [
        'totalDestinasi' => Destinasi::count(),
    ]);
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi.index');
    Route::get('/destinasi/{destinasi}', [DestinasiController::class, 'show'])->name('destinasi.show');

    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::post('/rekomendasi', [RekomendasiController::class, 'proses'])->name('rekomendasi.proses');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/saved-plans', [SavedPlanController::class, 'index'])->name('saved-plans.index');
    Route::post('/saved-plans/{destinasi}', [SavedPlanController::class, 'store'])->name('saved-plans.store');
    Route::delete('/saved-plans', [SavedPlanController::class, 'clear'])->name('saved-plans.clear');
    Route::delete('/saved-plans/{savedPlan}', [SavedPlanController::class, 'destroy'])->name('saved-plans.destroy');

    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai-assistant.index');
    Route::post('/ai-assistant/ask', [AiAssistantController::class, 'ask'])->name('ai-assistant.ask');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', function () {
            $totalDestinations = Destinasi::count();

            $totalCities = Destinasi::distinct('kota')
                ->count('kota');

            $totalCategories = Destinasi::distinct('kategori')
                ->count('kategori');

            $averageRating = Destinasi::avg('rating');

            return view('admin.dashboard', compact(
                'totalDestinations',
                'totalCities',
                'totalCategories',
                'averageRating'
            ));
        })->name('admin.dashboard');

        Route::get('/destinations', [AdminDestinationController::class, 'index'])
            ->name('destinations.index');

        Route::get('/destinations/create', [AdminDestinationController::class, 'create'])
            ->name('destinations.create');

        Route::post('/destinations', [AdminDestinationController::class, 'store'])
            ->name('destinations.store');

        Route::get('/destinations/{id}/edit', [AdminDestinationController::class, 'edit'])
            ->name('destinations.edit');

        Route::put('/destinations/{id}', [AdminDestinationController::class, 'update'])
            ->name('destinations.update');

        Route::delete('/destinations/{id}', [AdminDestinationController::class, 'destroy'])
            ->name('destinations.destroy');

        Route::get('/import', [AdminImportController::class, 'index'])
            ->name('import.index');

        Route::post('/import', [AdminImportController::class, 'store'])
            ->name('import.store');
    });
});

require __DIR__.'/auth.php';