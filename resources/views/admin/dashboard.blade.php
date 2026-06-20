@extends('layouts.admin')

@section('title', 'Dashboard Admin - Wisata AI')

@section('content')

    <div class="card border-0 shadow-card mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">

                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">
                        Selamat Datang di Wisata AI Admin!
                    </h2>

                    <p class="text-muted mb-0">
                        Kelola data destinasi wisata Indonesia yang terhubung langsung dengan halaman Explore, Recommendation, Map, dan AI Assistant.
                    </p>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('destinations.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Destinasi
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="page-header">
        <h1>Dashboard Admin</h1>
        <p>Ringkasan data destinasi wisata dalam sistem.</p>
    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card shadow-card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Total Destinasi</div>
                        <h2 class="mb-0">{{ $totalDestinations }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-buildings-fill"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Total Kota</div>
                        <h2 class="mb-0">{{ $totalCities }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-tags-fill"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Total Kategori</div>
                        <h2 class="mb-0">{{ $totalCategories }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Rating Rata-rata</div>
                        <h2 class="mb-0">{{ number_format($averageRating ?? 0, 1) }}</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-1">

        <div class="col-md-6">
            <div class="card shadow-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-database-fill me-2 text-primary"></i>
                        Data Terhubung
                    </h5>

                    <p class="text-muted mb-3">
                        Perubahan data destinasi dari halaman admin akan langsung memengaruhi fitur user.
                    </p>

                    <ul class="list-unstyled mb-0 text-muted">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Explore Destinations
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            AI Recommendation
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Tourism Map
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            AI Assistant
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-tools me-2 text-primary"></i>
                        Menu Admin
                    </h5>

                    <div class="d-grid gap-2">
                        <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Kelola Data Destinasi
                        </a>

                        <a href="{{ route('destinations.create') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Tambah Destinasi Baru
                        </a>

                        <a href="{{ route('import.index') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-cloud-upload-fill me-2"></i>
                            Import Dataset CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
