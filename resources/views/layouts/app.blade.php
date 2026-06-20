<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travel Insight AI') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Figtree, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            background: #f8fafc;
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 40;
        }

        .sidebar-brand {
            height: 78px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 36px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
        }

        .sidebar-logo {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            object-fit: cover;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.18);
        }

        .sidebar-menu {
            padding: 20px 36px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            border-radius: 13px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-link:hover {
            background: #e0f7fb;
            color: #0891b2;
        }

        .sidebar-link.active {
            background: #14b8c9;
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(20, 184, 201, 0.20);
        }

        .sidebar-footer {
            padding: 20px 36px 32px;
        }

        .sidebar-divider {
            height: 1px;
            background: #e2e8f0;
            margin-bottom: 18px;
        }

        .logout-button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            border: none;
            background: transparent;
            border-radius: 13px;
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .logout-button:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .main-wrapper {
            width: 100%;
            min-height: 100vh;
            margin-left: 280px;
        }

        .topbar {
            height: 78px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 18px;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .notification-wrapper {
            position: relative;
        }

        .notification-button {
            position: relative;
            border: none;
            background: transparent;
            color: #0f172a;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 999px;
            transition: 0.2s ease;
        }

        .notification-button:hover {
            background: #f1f5f9;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -1px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #10b981;
            color: #ffffff;
            font-size: 11px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-dropdown {
            position: absolute;
            top: 48px;
            right: 0;
            width: 320px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.16);
            display: none;
            overflow: hidden;
            z-index: 100;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-header h4 {
            font-size: 15px;
            font-weight: 900;
            color: #0f172a;
            margin: 0;
        }

        .notification-header span {
            font-size: 12px;
            font-weight: 800;
            color: #10b981;
        }

        .notification-list {
            max-height: 280px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s ease;
        }

        .notification-item:hover {
            background: #f8fafc;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #e0f7fb;
            color: #0891b2;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-content strong {
            display: block;
            font-size: 13px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .notification-content p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
        }

        .notification-time {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }

        /* .notification-footer {
            padding: 12px 18px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .notification-footer a {
            font-size: 13px;
            color: #2563eb;
            font-weight: 900;
        } */

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.22);
        }

        .page-content {
            padding: 30px 42px 48px 56px;
        }

        .page-heading {
            margin-bottom: 24px;
            padding-left: 56px !important;
            padding-right: 42px !important;
        }

        .mobile-brand {
            display: none;
        }

        @media (max-width: 900px) {
            .app-shell {
                display: block;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }

            .sidebar-brand {
                height: auto;
                padding: 18px 20px;
            }

            .sidebar-menu {
                padding: 12px 20px 16px;
                flex-direction: row;
                overflow-x: auto;
            }

            .sidebar-link {
                white-space: nowrap;
            }

            .sidebar-footer {
                display: none;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .topbar {
                height: 64px;
                padding: 0 20px;
            }

            .page-content {
                padding: 24px 20px 40px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="app-shell">

        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img
                    src="{{ asset('images/logo-ai-travel.jpeg') }}"
                    alt="Travel Insight AI Logo"
                    class="sidebar-logo"
                >
                <span>Travel Insight AI</span>
            </a>

            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('ai-assistant.index') }}"
                   class="sidebar-link {{ request()->routeIs('ai-assistant.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left"></i>
                    <span>AI Assistant</span>
                </a>

                <a href="{{ route('destinasi.index') }}"
                   class="sidebar-link {{ request()->routeIs('destinasi.*') ? 'active' : '' }}">
                    <i class="bi bi-compass"></i>
                    <span>Explore</span>
                </a>

                <a href="{{ route('map.index') }}"
                   class="sidebar-link {{ request()->routeIs('map.*') ? 'active' : '' }}">
                    <i class="bi bi-map"></i>
                    <span>Tourism Map</span>
                </a>

                <a href="{{ route('rekomendasi.index') }}"
                   class="sidebar-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}">
                    <i class="bi bi-lightbulb"></i>
                    <span>AI Insights</span>
                </a>

                <a href="{{ route('saved-plans.index') }}"
                   class="sidebar-link {{ request()->routeIs('saved-plans.*') ? 'active' : '' }}">
                    <i class="bi bi-heart"></i>
                    <span>Saved Plans</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Area -->
        <div class="main-wrapper">

            <!-- Topbar -->
            <header class="topbar">
                <div class="notification-wrapper">
                    <button type="button" class="notification-button" onclick="toggleNotifications(event)">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <div id="notificationDropdown" class="notification-dropdown">
                        <div class="notification-header">
                            <h4>Notifications</h4>
                            <span>3 New</span>
                        </div>

                        <div class="notification-list">
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="notification-content">
                                    <strong>AI Recommendation Ready</strong>
                                    <p>Your personalized destination recommendations are ready to explore.</p>
                                    <div class="notification-time">Just now</div>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="notification-content">
                                    <strong>Saved Plan Updated</strong>
                                    <p>Your saved travel plan has been updated successfully.</p>
                                    <div class="notification-time">10 minutes ago</div>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="notification-content">
                                    <strong>New Destination Available</strong>
                                    <p>New tourism destinations have been added to the Explore page.</p>
                                    <div class="notification-time">1 hour ago</div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="notification-footer">
                            <a href="{{ route('dashboard') }}">View Activity</a>
                        </div> --}}
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="user-avatar" style="overflow: hidden;">
                    @if (auth()->user()->profile_photo)
                        <img
                            src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                            alt="Profile Photo"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                        >
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    @endif
                </a>
            </header>

            <!-- Page Heading -->
            @isset($header)
                <section class="page-heading px-10 pt-8">
                    {{ $header }}
                </section>
            @endisset

            <!-- Page Content -->
            <main class="page-content">
                {{ $slot }}
            </main>
        </div>
    </div>
        <script>
            function toggleNotifications(event) {
                event.stopPropagation();

                const dropdown = document.getElementById('notificationDropdown');

                if (dropdown) {
                    dropdown.classList.toggle('show');
                }
            }

            document.addEventListener('click', function (event) {
                const dropdown = document.getElementById('notificationDropdown');
                const wrapper = document.querySelector('.notification-wrapper');

                if (dropdown && wrapper && !wrapper.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        </script>
    @stack('scripts')
</body>
</html>