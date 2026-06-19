<?php

namespace App\Http\Controllers;

use App\Models\SavedPlan;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPlanController extends Controller
{
    public function index()
    {
        $savedPlans = SavedPlan::with('destinasi')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('saved-plans.index', compact('savedPlans'));
    }

    public function store(Request $request, Destinasi $destinasi)
    {
        $savedPlan = SavedPlan::where('user_id', Auth::id())
            ->where('destinasi_id', $destinasi->id)
            ->first();

        if ($savedPlan) {
            $savedPlan->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'saved' => false,
                    'message' => 'Destinasi berhasil dihapus dari Saved Plans.',
                ]);
            }

            return redirect()->back()->with('success', 'Destinasi berhasil dihapus dari Saved Plans.');
        }

        SavedPlan::create([
            'user_id' => Auth::id(),
            'destinasi_id' => $destinasi->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'saved' => true,
                'message' => 'Destinasi berhasil disimpan ke Saved Plans.',
            ]);
        }

        return redirect()->back()->with('success', 'Destinasi berhasil disimpan ke Saved Plans.');
    }

    public function destroy(SavedPlan $savedPlan)
    {
        if ($savedPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $savedPlan->delete();

        return redirect()->back()->with('success', 'Destinasi berhasil dihapus dari Saved Plans.');
    }
    public function clear()
    {
        SavedPlan::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Semua destinasi berhasil dihapus dari Saved Plans.');
    }
}