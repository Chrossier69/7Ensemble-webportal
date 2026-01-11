<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - 7 Ensemble</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js', 'resources/js/dashboard.js'])

    {{-- Chart.js for graphs --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 3px solid #4ecdc4;
        }

        .sidebar-nav a i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Dashboard Header */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h1 {
            color: white;
            font-size: 1.75rem;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #4ecdc4;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-nav a span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .sidebar-logo span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        {{-- Sidebar Navigation --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2 style="color: white; margin: 0;">
                    <span>⭐ 7 Ensemble</span>
                </h2>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                            <i>📊</i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.constellation.index') }}" class="{{ request()->routeIs('dashboard.constellation.*') ? 'active' : '' }}">
                            <i>✨</i>
                            <span>Ma Constellation</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.tours.index') }}" class="{{ request()->routeIs('dashboard.tours.*') ? 'active' : '' }}">
                            <i>🚀</i>
                            <span>Mes Tours</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.payments.index') }}" class="{{ request()->routeIs('dashboard.payments.*') ? 'active' : '' }}">
                            <i>💳</i>
                            <span>Paiements</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.transfers.index') }}" class="{{ request()->routeIs('dashboard.transfers.*') ? 'active' : '' }}">
                            <i>💰</i>
                            <span>Transferts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.referrals.index') }}" class="{{ request()->routeIs('dashboard.referrals.*') ? 'active' : '' }}">
                            <i>👥</i>
                            <span>Parrainages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.settings.index') }}" class="{{ request()->routeIs('dashboard.settings.*') ? 'active' : '' }}">
                            <i>⚙️</i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.support.index') }}" class="{{ request()->routeIs('dashboard.support.*') ? 'active' : '' }}">
                            <i>💬</i>
                            <span>Support</span>
                        </a>
                    </li>
                    <li style="margin-top: 2rem;">
                        <a href="{{ route('home') }}">
                            <i>🏠</i>
                            <span>Retour au site</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                                <a>
                                    <i>🚪</i>
                                    <span>Déconnexion</span>
                                </a>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content Area --}}
        <main class="main-content">
            {{-- Dashboard Header --}}
            <header class="dashboard-header">
                <h1>@yield('page-title', 'Dashboard')</h1>

                <div class="user-info">
                    {{-- Notifications --}}
                    <div class="notifications" x-data="{ open: false }">
                        <button @click="open = !open" style="background: rgba(255,255,255,0.2); border: none; padding: 0.5rem 1rem; border-radius: 8px; color: white; cursor: pointer;">
                            🔔 <span style="background: #ff6b6b; border-radius: 50%; padding: 2px 6px; font-size: 0.8rem;">3</span>
                        </button>
                    </div>

                    {{-- User Avatar --}}
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>

                    <div style="color: white;">
                        <div style="font-weight: 600;">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                        <div style="font-size: 0.85rem; opacity: 0.8;">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success" style="background: rgba(76, 175, 80, 0.2); color: #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #4caf50;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" style="background: rgba(244, 67, 54, 0.2); color: #f44336; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #f44336;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </main>
    </div>

    {{-- Modals --}}
    @stack('modals')

    {{-- Scripts --}}
    @stack('scripts')

    <script>
        // CSRF Token
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
