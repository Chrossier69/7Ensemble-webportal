<section class="hero-section">
    <div class="container">
        <div class="hero-content" data-aos="fade-down">
            {{-- Heart Icon --}}
            <div class="hero-icon">
                ❤️
            </div>

            {{-- Main Heading --}}
            <h1 class="hero-title">
                Avec tout mon amour
            </h1>

            {{-- Hand Illustration (using emoji) --}}
            <div class="hero-hand">
                🤝
            </div>

            {{-- Dancing Silhouettes --}}
            <div class="dancing-silhouettes">
                <div class="silhouette" style="animation-delay: 0s;">🕺</div>
                <div class="silhouette" style="animation-delay: 0.2s;">💃</div>
                <div class="silhouette" style="animation-delay: 0.4s;">🕺</div>
                <div class="silhouette" style="animation-delay: 0.6s;">💃</div>
                <div class="silhouette" style="animation-delay: 0.8s;">🕺</div>
                <div class="silhouette" style="animation-delay: 1.0s;">💃</div>
                <div class="silhouette" style="animation-delay: 1.2s;">🕺</div>
            </div>

            {{-- Subheading --}}
            <p class="hero-subtitle">
                Transformez 21€ en opportunités extraordinaires<br>
                Rejoignez une constellation et changez votre vie
            </p>

            {{-- CTA Buttons --}}
            <div class="hero-buttons">
                <button onclick="openModal('sevenModal')" class="btn btn-primary btn-hero">
                    ✨ Les Pléiades (7 personnes)
                </button>
                <button onclick="openModal('threeModal')" class="btn btn-secondary btn-hero">
                    🔺 Triangulum (3 personnes)
                </button>
            </div>

            {{-- Scroll Indicator --}}
            <div class="scroll-indicator" data-aos="fade-up" data-aos-delay="1000">
                <span>Découvrez comment</span>
                <div class="scroll-arrow">⬇️</div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 4rem 2rem;
    position: relative;
}

.hero-icon {
    font-size: 4rem;
    animation: pulse 2s ease-in-out infinite;
    margin-bottom: 1rem;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 2rem;
}

.hero-hand {
    font-size: 5rem;
    margin: 2rem 0;
    animation: wave 2s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
}

.dancing-silhouettes {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin: 2rem 0;
}

.silhouette {
    font-size: 2.5rem;
    animation: dance 1.5s ease-in-out infinite;
}

@keyframes dance {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.1); }
}

.hero-subtitle {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2.5rem;
    line-height: 1.8;
}

.hero-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-hero {
    font-size: 1.1rem;
    padding: 1rem 2.5rem;
}

.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.scroll-arrow {
    font-size: 1.5rem;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(10px); }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-hand {
        font-size: 3.5rem;
    }

    .dancing-silhouettes {
        gap: 0.5rem;
    }

    .silhouette {
        font-size: 1.8rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-hero {
        width: 100%;
        max-width: 300px;
    }
}
</style>
