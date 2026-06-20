@extends('layouts.admin')

@section('title', 'Tambah Destinasi - Wisata AI Admin')

@section('content')

<div class="page-header">
    <h1>Tambah Destinasi</h1>
    <p>Tambahkan destinasi wisata baru ke dalam sistem utama.</p>
</div>

<div class="card shadow-card card-form">
    <div class="card-body p-4">

        <form action="{{ route('destinations.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- Informasi Utama --}}
                <div class="col-12">
                    <div class="border rounded-4 p-4">

                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Informasi Destinasi
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama Wisata</label>

                                <input
                                    type="text"
                                    name="nama_wisata"
                                    class="form-control @error('nama_wisata') is-invalid @enderror"
                                    placeholder="Contoh: Pantai Kuta"
                                    value="{{ old('nama_wisata') }}"
                                    required
                                >

                                @error('nama_wisata')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kategori</label>

                                <select
                                    name="kategori"
                                    class="form-select @error('kategori') is-invalid @enderror"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category }}"
                                            {{ old('kategori') == $category ? 'selected' : '' }}
                                        >
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kota</label>

                                <input
                                    type="text"
                                    name="kota"
                                    class="form-control @error('kota') is-invalid @enderror"
                                    placeholder="Contoh: Bandung"
                                    value="{{ old('kota') }}"
                                    required
                                >

                                @error('kota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>

                                <input
                                    type="text"
                                    name="provinsi"
                                    class="form-control @error('provinsi') is-invalid @enderror"
                                    placeholder="Contoh: Jawa Barat"
                                    value="{{ old('provinsi') }}"
                                    required
                                >

                                @error('provinsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Harga Tiket (Rp)</label>

                                <input
                                    type="number"
                                    name="harga_tiket"
                                    class="form-control @error('harga_tiket') is-invalid @enderror"
                                    placeholder="Contoh: 50000"
                                    min="0"
                                    step="1"
                                    value="{{ old('harga_tiket', 0) }}"
                                    required
                                >

                                <div class="form-text">
                                    Isi 0 jika destinasi gratis. Harga tidak boleh minus.
                                </div>

                                @error('harga_tiket')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Rating</label>

                                <input
                                    type="number"
                                    name="rating"
                                    class="form-control @error('rating') is-invalid @enderror"
                                    placeholder="Contoh: 4.5"
                                    min="0"
                                    max="5"
                                    step="0.1"
                                    value="{{ old('rating', 0) }}"
                                >

                                <div class="form-text">
                                    Gunakan nilai 0 sampai 5.
                                </div>

                                @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Durasi Kunjungan (Menit)</label>

                                <input
                                    type="number"
                                    name="time_minutes"
                                    class="form-control @error('time_minutes') is-invalid @enderror"
                                    placeholder="Contoh: 120"
                                    min="0"
                                    step="1"
                                    value="{{ old('time_minutes') }}"
                                >

                                @error('time_minutes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Latitude</label>

                                <input
                                    type="number"
                                    name="latitude"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    placeholder="Contoh: -6.175392"
                                    step="any"
                                    value="{{ old('latitude') }}"
                                >

                                @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Longitude</label>

                                <input
                                    type="number"
                                    name="longitude"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    placeholder="Contoh: 106.827153"
                                    step="any"
                                    value="{{ old('longitude') }}"
                                >

                                @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                    <div class="border rounded-4 p-4">

                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2"></i>
                            Deskripsi Destinasi
                        </h5>

                        <textarea
                            name="deskripsi"
                            rows="5"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan deskripsi destinasi wisata..."
                        >{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-light">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Destinasi
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
