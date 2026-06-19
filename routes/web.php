<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\SavedPlanController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AiAssistantController;
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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/saved-plans', [SavedPlanController::class, 'index'])->name('saved-plans.index');
    Route::post('/saved-plans/{destinasi}', [SavedPlanController::class, 'store'])->name('saved-plans.store');
    Route::delete('/saved-plans', [SavedPlanController::class, 'clear'])->name('saved-plans.clear');
    Route::delete('/saved-plans/{savedPlan}', [SavedPlanController::class, 'destroy'])->name('saved-plans.destroy');

    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai-assistant.index');
    Route::post('/ai-assistant/ask', [AiAssistantController::class, 'ask'])->name('ai-assistant.ask');
});

require __DIR__.'/auth.php';
