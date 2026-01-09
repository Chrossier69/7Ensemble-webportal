{{-- Footer Component --}}
<footer class="site-footer">
    <div class="footer-container">
        {{-- Footer Top Section --}}
        <div class="footer-top">
            <div class="footer-grid">
                {{-- Column 1: About --}}
                <div class="footer-column">
                    <div class="footer-logo">
                        <span class="logo-icon">⭐</span>
                        <span class="logo-text">7 Ensemble</span>
                    </div>
                    <p class="footer-description">
                        Rejoignez notre communauté d'entraide financière et transformez 21€ en opportunités extraordinaires grâce au pouvoir des constellations.
                    </p>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i>📘</i></a>
                        <a href="#" title="Twitter"><i>🐦</i></a>
                        <a href="#" title="Instagram"><i>📷</i></a>
                        <a href="#" title="LinkedIn"><i>💼</i></a>
                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="footer-column">
                    <h3>Liens Rapides</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('tours.index') }}">Les 7 Tours</a></li>
                        <li><a href="{{ route('mission') }}">Notre Mission</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                {{-- Column 3: Constellation Types --}}
                <div class="footer-column">
                    <h3>Nos Constellations</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('tours.show', 'triangulum') }}">Triangulum (3 personnes)</a></li>
                        <li><a href="{{ route('tours.show', 'pleiades') }}">Les Pléiades (7 personnes)</a></li>
                        @auth
                            <li><a href="{{ route('dashboard.constellation.index') }}">Ma Constellation</a></li>
                            <li><a href="{{ route('dashboard.tours.index') }}">Mes Tours</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Column 4: Legal & Support --}}
                <div class="footer-column">
                    <h3>Support & Légal</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('terms') }}">Conditions d'utilisation</a></li>
                        <li><a href="{{ route('privacy') }}">Politique de confidentialité</a></li>
                        <li><a href="{{ route('legal') }}">Mentions légales</a></li>
                        @auth
                            <li><a href="{{ route('dashboard.support.index') }}">Centre d'aide</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>

        {{-- Footer Bottom Section --}}
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p class="copyright">
                    &copy; {{ date('Y') }} 7 Ensemble. Tous droits réservés.
                </p>
                <div class="payment-methods">
                    <span>Paiements acceptés:</span>
                    <i title="Cartes bancaires">💳</i>
                    <i title="PayPal">🅿️</i>
                    <i title="Virement bancaire">🏦</i>
                    <i title="Mobile Money">📱</i>
                </div>
                <div class="language-selector">
                    <select onchange="changeLanguage(this.value)" class="lang-select">
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        <option value="de" {{ app()->getLocale() == 'de' ? 'selected' : '' }}>🇩🇪 Deutsch</option>
                        <option value="it" {{ app()->getLocale() == 'it' ? 'selected' : '' }}>🇮🇹 Italiano</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Back to Top Button --}}
        <button onclick="scrollToTop()" class="back-to-top" id="backToTop" title="Retour en haut">
            ⬆️
        </button>
    </div>
</footer>

<style>
    .site-footer {
        background: rgba(15, 20, 25, 0.9);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        margin-top: 4rem;
        position: relative;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3rem 2rem 1rem;
    }

    /* Footer Top */
    .footer-top {
        margin-bottom: 2rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .footer-column h3 {
        color: #4ecdc4;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    /* Footer Logo */
    .footer-logo {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .footer-logo .logo-icon {
        font-size: 2rem;
        margin-right: 0.5rem;
    }

    .footer-logo .logo-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .footer-description {
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    /* Social Links */
    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        text-decoration: none;
        font-size: 1.2rem;
        transition: all 0.3s;
    }

    .social-links a:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        transform: translateY(-3px);
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .footer-links a:hover {
        color: #4ecdc4;
        padding-left: 5px;
    }

    /* Footer Bottom */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1.5rem;
        margin-top: 2rem;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        margin: 0;
    }

    .payment-methods {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .payment-methods i {
        font-size: 1.5rem;
        filter: grayscale(1);
        opacity: 0.6;
        transition: all 0.3s;
    }

    .payment-methods i:hover {
        filter: grayscale(0);
        opacity: 1;
    }

    /* Language Selector */
    .lang-select {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .lang-select option {
        background: #1a237e;
        color: white;
    }

    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        z-index: 999;
    }

    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
    }

    .back-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.5);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }

        .footer-container {
            padding: 2rem 1rem 1rem;
        }
    }
</style>

<script>
    // Back to Top Button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.pageYOffset > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Language Switcher
    function changeLanguage(locale) {
        window.location.href = `/lang/${locale}`;
    }
</script>
