<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\SavedPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Destinasi::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_wisata', 'like', '%' . $request->search . '%')
                    ->orWhere('kota', 'like', '%' . $request->search . '%')
                    ->orWhere('provinsi', 'like', '%' . $request->search . '%')
                    ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('provinsi')) {
            $query->where('provinsi', $request->provinsi);
        }

        if ($request->filled('budget')) {
            if ($request->budget === 'free') {
                $query->where('harga_tiket', 0);
            }

            if ($request->budget === 'low') {
                $query->whereBetween('harga_tiket', [1, 50000]);
            }

            if ($request->budget === 'medium') {
                $query->whereBetween('harga_tiket', [50001, 150000]);
            }

            if ($request->budget === 'high') {
                $query->where('harga_tiket', '>', 150000);
            }
        }

        $destinasis = $query->latest()->get();

        $kategoris = Destinasi::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $provinsis = Destinasi::select('provinsi')
            ->distinct()
            ->orderBy('provinsi')
            ->pluck('provinsi');

        $savedDestinasiIds = SavedPlan::where('user_id', Auth::id())
            ->pluck('destinasi_id')
            ->toArray();

        return view('destinasi.index', compact(
            'destinasis',
            'kategoris',
            'provinsis',
            'savedDestinasiIds'
        ));
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Destinasi $destinasi)
    {
        $isSaved = SavedPlan::where('user_id', Auth::id())
            ->where('destinasi_id', $destinasi->id)
            ->exists();

        return view('destinasi.show', compact('destinasi', 'isSaved'));
    }

    public function edit(Destinasi $destinasi)
    {
        //
    }

    public function update(Request $request, Destinasi $destinasi)
    {
        //
    }

    public function destroy(Destinasi $destinasi)
    {
        //
    }
}