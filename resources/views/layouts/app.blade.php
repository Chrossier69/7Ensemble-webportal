<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', '7 Ensemble - Votre Nouvelle Aventure Financière')</title>
    <meta name="description" content="@yield('description', 'Rejoignez 7 Ensemble et transformez 21€ en opportunités extraordinaires grâce au pouvoir des constellations financières.')">
    <meta name="keywords" content="7 ensemble, constellation financière, entraide mutuelle, pléiades, triangulum">
    <meta name="author" content="7 Ensemble">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="@yield('og_title', '7 Ensemble - Votre Nouvelle Aventure Financière')">
    <meta property="og:description" content="@yield('og_description', 'Rejoignez notre communauté d\'entraide financière')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets (Laravel Mix alternative) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Additional Styles --}}
    @stack('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(180deg, #0f1419 0%, #1a237e 30%, #3949ab 60%, #5c6bc0 85%, #9c27b0 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* Cosmic background with twinkling stars */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(2px 2px at 20px 30px, white, transparent),
                radial-gradient(2px 2px at 60px 70px, white, transparent),
                radial-gradient(1px 1px at 50px 50px, white, transparent),
                radial-gradient(1px 1px at 130px 80px, white, transparent),
                radial-gradient(2px 2px at 90px 10px, white, transparent);
            background-repeat: repeat;
            background-size: 200px 200px;
            animation: twinkle 5s ease-in-out infinite;
            opacity: 0.5;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Ensure content is above background */
        .content-wrapper {
            position: relative;
            z-index: 2;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #667eea, #764ba2);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #764ba2, #f093fb);
        }
    </style>

    {{-- Analytics (Production only) --}}
    @if(app()->environment('production'))
        @if(config('services.google_analytics.id'))
            <!-- Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ config('services.google_analytics.id') }}');
            </script>
        @endif
    @endif
</head>
<body>
    <div class="content-wrapper">
        {{-- Header Navigation --}}
        @include('components.header')

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.footer')
    </div>

    {{-- Modals Section --}}
    @stack('modals')

    {{-- Scripts --}}
    @stack('scripts')

    {{-- Global JavaScript --}}
    <script>
        // CSRF Token setup for AJAX requests
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Flash message auto-hide
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Number animation on scroll
        function animateNumbers() {
            const numbers = document.querySelectorAll('.animate-number');
            numbers.forEach(num => {
                const target = parseInt(num.getAttribute('data-target'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && current === 0) {
                            const timer = setInterval(() => {
                                current += step;
                                if (current >= target) {
                                    current = target;
                                    clearInterval(timer);
                                }
                                num.textContent = Math.floor(current).toLocaleString('fr-FR');
                            }, 16);
                        }
                    });
                });

                observer.observe(num);
            });
        }

        // Initialize on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', animateNumbers);
        } else {
            animateNumbers();
        }
    </script>
</body>
</html>
