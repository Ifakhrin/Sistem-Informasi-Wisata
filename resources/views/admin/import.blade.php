@extends('layouts.admin')

@section('title', 'Import Dataset - Wisata AI Admin')

@section('content')

    <div class="page-header">
        <h1>Import Dataset Wisata</h1>
        <p>Unggah file CSV untuk menambahkan atau memperbarui data destinasi secara massal.</p>
    </div>

    <div class="card shadow-card card-form">
        <div class="card-body p-4">

            <div class="alert alert-info border-0 shadow-sm mb-4">
                <div class="d-flex gap-3">
                    <div>
                        <i class="bi bi-info-circle-fill fs-4"></i>
                    </div>

                    <div>
                        <strong>Format CSV yang didukung</strong>
                        <p class="mb-2 mt-1">
                            Sistem mendukung format dataset wisata dengan kolom seperti:
                        </p>

                        <code>
                            Place_Id, Place_Name, Description, Category, City, Price, Rating, Time_Minutes, Lat, Long
                        </code>

                        <p class="mb-0 mt-2">
                            Data akan masuk ke tabel utama <strong>destinasis</strong>, sehingga langsung terhubung ke Explore, Recommendation, Map, dan AI Assistant.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">File CSV</label>

                    <input
                        type="file"
                        name="file"
                        accept=".csv,.txt"
                        class="form-control @error('file') is-invalid @enderror"
                        required
                    >

                    <div class="form-text">
                        Gunakan file berformat .csv atau .txt. Data dengan Place_Id yang sama akan diperbarui, bukan diduplikasi.
                    </div>

                    @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
                    <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cloud-upload-fill me-1"></i>
                        Import CSV
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection