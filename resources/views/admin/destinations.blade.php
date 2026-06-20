@extends('layouts.admin')

@section('title', 'Data Destinasi - Wisata AI Admin')

@section('content')

    <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-2">
        <div>
            <h1>Data Destinasi Wisata</h1>
            <p>Kelola seluruh data destinasi wisata yang digunakan pada sistem rekomendasi.</p>
        </div>

        <a href="{{ route('destinations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-card">
                <div class="card-body">
                    <small class="text-muted">Total Destinasi</small>
                    <h3 class="mb-0">{{ $destinations->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-card">
        <div class="card-body">

            <form method="GET" action="{{ route('destinations.index') }}" class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari nama wisata, kategori, kota, atau provinsi..."
                        value="{{ $search ?? request('search') }}"
                    >

                    @if (request('search'))
                        <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Wisata</th>
                            <th>Kategori</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Rating</th>
                            <th>Harga</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($destinations as $destination)
                            <tr>
                                <td>
                                    {{ $destinations->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $destination->nama_wisata }}
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $destination->kategori }}
                                    </span>
                                </td>

                                <td>
                                    {{ $destination->kota }}
                                </td>

                                <td>
                                    {{ $destination->provinsi }}
                                </td>

                                <td>
                                    ⭐ {{ $destination->rating ?? '-' }}
                                </td>

                                <td>
                                    @if (($destination->harga_tiket ?? 0) == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($destination->harga_tiket ?? 0, 0, ',', '.') }}
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('destinations.edit', $destination->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <form action="{{ route('destinations.destroy', $destination->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus destinasi ini? Data yang dihapus juga tidak akan tampil di fitur user.')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data destinasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $destinations->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

@endsection
