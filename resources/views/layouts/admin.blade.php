<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wisata AI Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --accent: #06b6d4;
            --dark: #0f172a;
        }

        body {
            background-color: #f8fafc;
            font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: .2px;
        }
        .admin-logo {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 6px 16px rgba(56, 189, 248, 0.25);
        }
        .nav-link {
            font-weight: 600;
            font-size: 14px;
        }

        .nav-link.active {
            color: #fff !important;
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 1rem;
            right: 1rem;
            bottom: -2px;
            height: 2px;
            background: #38bdf8;
            border-radius: 2px;
        }

        .card {
            border: none;
            border-radius: 20px;
            transition: .25s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card.shadow,
        .shadow-card {
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08) !important;
        }

        .stat-card h2 {
            font-weight: 800;
            color: var(--brand-dark);
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .btn-primary {
            background-color: var(--brand);
            border-color: var(--brand);
            font-weight: 700;
        }

        .btn-primary:hover {
            background-color: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        .btn-warning {
            color: #fff;
            font-weight: 700;
        }

        .btn-danger {
            font-weight: 700;
        }

        .table thead {
            background-color: #eef2ff;
        }

        .table thead th {
            font-weight: 700;
            color: #334155;
            border-bottom: none;
            font-size: 14px;
        }

        .table td {
            font-size: 14px;
            color: #334155;
        }

        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-header h1 {
            font-weight: 800;
            font-size: 1.65rem;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #64748b;
            margin-bottom: 0;
        }

        .form-label {
            font-weight: 700;
            color: #334155;
            font-size: .92rem;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: #e2e8f0;
            padding: 10px 13px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
        }

        .card-form {
            border-radius: 18px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination svg {
            width: 14px !important;
            height: 14px !important;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            color: var(--brand);
            font-weight: 600;
        }

        .pagination .active > .page-link,
        .page-link.active {
            background-color: var(--brand);
            border-color: var(--brand);
        }

        .admin-container {
            max-width: 1180px;
        }

        .back-user-link {
            color: #cbd5e1 !important;
        }

        .back-user-link:hover {
            color: #ffffff !important;
        }
    </style>

    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0f172a;">
    <div class="container admin-container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
            <img
                src="{{ asset('images/logo-ai-travel.jpeg') }}"
                alt="Travel Insight AI Logo"
                class="admin-logo"
            >
            <span>Travel Insight AI Admin</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav ms-auto align-items-lg-center">

                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>

                <a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}"
                   href="{{ route('destinations.index') }}">
                    <i class="bi bi-geo-alt-fill me-1"></i> Destinasi
                </a>

                <a class="nav-link {{ request()->routeIs('import.*') ? 'active' : '' }}"
                   href="{{ route('import.index') }}">
                    <i class="bi bi-cloud-upload-fill me-1"></i> Import Dataset
                </a>

                <a class="nav-link back-user-link ms-lg-3"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-arrow-left-circle me-1"></i> User Dashboard
                </a>

            </div>
        </div>

    </div>
</nav>

<div class="container admin-container py-4">

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <strong>Periksa kembali isian Anda:</strong>
            </div>

            <ul class="mb-0 ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
