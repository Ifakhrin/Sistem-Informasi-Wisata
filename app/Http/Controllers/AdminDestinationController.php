<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class AdminDestinationController extends Controller
{
    private function kategoriOptions(): array
    {
        $defaultCategories = [
            'Budaya',
            'Taman Hiburan',
            'Cagar Alam',
            'Bahari',
            'Tempat Ibadah',
            'Pusat Perbelanjaan',
        ];

        $databaseCategories = Destinasi::select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->toArray();

        return collect($defaultCategories)
            ->merge($databaseCategories)
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $destinations = Destinasi::when($search, function ($query, $search) {
                $query->where('nama_wisata', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.destinations', compact('destinations', 'search'));
    }

    public function create()
    {
        $categories = $this->kategoriOptions();

        return view('admin.create_destinations', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wisata'  => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'max:255'],
            'kota'         => ['required', 'string', 'max:255'],
            'provinsi'     => ['required', 'string', 'max:255'],
            'harga_tiket'  => ['required', 'integer', 'min:0'],
            'rating'       => ['nullable', 'numeric', 'min:0', 'max:5'],
            'time_minutes' => ['nullable', 'integer', 'min:0'],
            'latitude'     => ['nullable', 'numeric'],
            'longitude'    => ['nullable', 'numeric'],
            'deskripsi'    => ['nullable', 'string'],
        ]);

        Destinasi::create([
            'nama_wisata'  => $validated['nama_wisata'],
            'kategori'     => $validated['kategori'],
            'kota'         => $validated['kota'],
            'provinsi'     => $validated['provinsi'],
            'rating'       => $validated['rating'] ?? 0,
            'harga_tiket'  => $validated['harga_tiket'],
            'time_minutes' => $validated['time_minutes'] ?? null,
            'latitude'     => $validated['latitude'] ?? null,
            'longitude'    => $validated['longitude'] ?? null,
            'deskripsi'    => $validated['deskripsi'] ?? null,
            'gambar'       => null,
        ]);

        return redirect()
            ->route('destinations.index')
            ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $destination = Destinasi::findOrFail($id);
        $categories = $this->kategoriOptions();

        return view('admin.edit_destination', compact('destination', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destinasi::findOrFail($id);

        $validated = $request->validate([
            'nama_wisata'  => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'max:255'],
            'kota'         => ['required', 'string', 'max:255'],
            'provinsi'     => ['required', 'string', 'max:255'],
            'harga_tiket'  => ['required', 'integer', 'min:0'],
            'rating'       => ['nullable', 'numeric', 'min:0', 'max:5'],
            'time_minutes' => ['nullable', 'integer', 'min:0'],
            'latitude'     => ['nullable', 'numeric'],
            'longitude'    => ['nullable', 'numeric'],
            'deskripsi'    => ['nullable', 'string'],
        ]);

        $destination->update([
            'nama_wisata'  => $validated['nama_wisata'],
            'kategori'     => $validated['kategori'],
            'kota'         => $validated['kota'],
            'provinsi'     => $validated['provinsi'],
            'rating'       => $validated['rating'] ?? 0,
            'harga_tiket'  => $validated['harga_tiket'],
            'time_minutes' => $validated['time_minutes'] ?? null,
            'latitude'     => $validated['latitude'] ?? null,
            'longitude'    => $validated['longitude'] ?? null,
            'deskripsi'    => $validated['deskripsi'] ?? null,
        ]);

        return redirect()
            ->route('destinations.index')
            ->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $destination = Destinasi::findOrFail($id);
        $destination->delete();

        return redirect()
            ->route('destinations.index')
            ->with('success', 'Destinasi berhasil dihapus.');
    }
}
