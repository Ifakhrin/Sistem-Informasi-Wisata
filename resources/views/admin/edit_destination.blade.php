@extends('layouts.admin')

@section('title', 'Edit Destinasi - Wisata AI Admin')

@section('content')

    <div class="page-header">
        <h1>Edit Destinasi</h1>
        <p>
            Perbarui data destinasi:
            <strong>{{ $destination->nama_wisata }}</strong>
        </p>
    </div>

    <div class="card shadow-card card-form">
        <div class="card-body p-4">

            <form action="{{ route('destinations.update', $destination->id) }}" method="POST">
                @csrf
                @method('PUT')

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
                                        value="{{ old('nama_wisata', $destination->nama_wisata) }}"
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
                                                {{ old('kategori', $destination->kategori) == $category ? 'selected' : '' }}
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
                                        value="{{ old('kota', $destination->kota) }}"
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
                                        value="{{ old('provinsi', $destination->provinsi) }}"
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
                                        value="{{ old('harga_tiket', $destination->harga_tiket) }}"
                                        min="0"
                                        step="1000"
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
                                        value="{{ old('rating', $destination->rating) }}"
                                        min="0"
                                        max="5"
                                        step="0.1"
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
                                        value="{{ old('time_minutes', $destination->time_minutes) }}"
                                        min="0"
                                        step="1"
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
                                        value="{{ old('latitude', $destination->latitude) }}"
                                        step="any"
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
                                        value="{{ old('longitude', $destination->longitude) }}"
                                        step="any"
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
                            >{{ old('deskripsi', $destination->deskripsi) }}</textarea>

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
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i>
                        Update Destinasi
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection