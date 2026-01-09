{{-- Header Navigation Component --}}
<header class="site-header">
    <nav class="navbar">
        <div class="container">
            {{-- Logo --}}
            <div class="logo">
                <a href="{{ route('home') }}">
                    <span class="logo-icon">⭐</span>
                    <span class="logo-text">7 Ensemble</span>
                </a>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            {{-- Navigation Links --}}
            <ul class="nav-links">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="{{ route('tours.index') }}" class="{{ request()->routeIs('tours.*') ? 'active' : '' }}">
                        Les 7 Tours
                    </a>
                </li>
                <li>
                    <a href="{{ route('mission') }}" class="{{ request()->routeIs('mission') ? 'active' : '' }}">
                        Notre Mission
                    </a>
                </li>
                <li>
                    <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </li>
            </ul>

            {{-- Auth Buttons --}}
            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn btn-dashboard">
                        📊 Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<style>
    .site-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(15, 20, 25, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar {
        padding: 1rem 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Logo Styles */
    .logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .logo-icon {
        font-size: 2rem;
        margin-right: 0.5rem;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .logo-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
    }

    .mobile-menu-toggle span {
        width: 25px;
        height: 3px;
        background: white;
        margin: 3px 0;
        transition: 0.3s;
        border-radius: 2px;
    }

    /* Navigation Links */
    .nav-links {
        display: flex;
        list-style: none;
        gap: 2rem;
        margin: 0;
        padding: 0;
    }

    .nav-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        position: relative;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: #4ecdc4;
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(to right, #4ecdc4, #45b7d1);
        transition: width 0.3s;
    }

    .nav-links a:hover::after,
    .nav-links a.active::after {
        width: 100%;
    }

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn {
        padding: 0.65rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-dashboard {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 968px) {
        .mobile-menu-toggle {
            display: flex;
        }

        .nav-links {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(15, 20, 25, 0.95);
            backdrop-filter: blur(10px);
            flex-direction: column;
            padding: 2rem;
            gap: 1rem;
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s;
        }

        .nav-links.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        .auth-buttons {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(15, 20, 25, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem 2rem;
            flex-direction: column;
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s;
        }

        .auth-buttons.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 1rem;
        }

        .logo-text {
            font-size: 1.2rem;
        }
    }
</style>

<script>
    function toggleMobileMenu() {
        const navLinks = document.querySelector('.nav-links');
        const authButtons = document.querySelector('.auth-buttons');
        const toggle = document.querySelector('.mobile-menu-toggle');

        navLinks.classList.toggle('active');
        authButtons.classList.toggle('active');
        toggle.classList.toggle('active');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const header = document.querySelector('.site-header');
        const toggle = document.querySelector('.mobile-menu-toggle');

        if (!header.contains(event.target) || event.target === toggle) {
            return;
        }

        if (!toggle.contains(event.target) && window.innerWidth <= 968) {
            document.querySelector('.nav-links').classList.remove('active');
            document.querySelector('.auth-buttons').classList.remove('active');
        }
    });
</script>
