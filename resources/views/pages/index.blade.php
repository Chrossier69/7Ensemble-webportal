@extends('layouts.app')

@section('title', '7 Ensemble - Votre Nouvelle Aventure Financière')
@section('description', 'Rejoignez 7 Ensemble et transformez 21€ en opportunités extraordinaires grâce au pouvoir des constellations financières.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cosmic-theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">
@endpush

@section('content')

{{-- Hero Section --}}
@include('components.hero-section')

{{-- Constellation Visualizations --}}
<section class="constellation-section" id="constellations">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">
            Choisissez Votre Constellation
        </h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Deux options pour votre voyage financier
        </p>

        <div class="constellation-grid">
            {{-- Triangulum (3 people) --}}
            @include('components.constellation-visual', [
                'type' => 'triangulum',
                'members' => 3,
                'name' => 'Triangulum',
                'initial' => 21,
                'total' => 7789,
                'data' => $constellations['triangulum']
            ])

            {{-- Pléiades (7 people) --}}
            @include('components.constellation-visual', [
                'type' => 'pleiades',
                'members' => 7,
                'name' => 'Les Pléiades',
                'initial' => 21,
                'total' => 1575747,
                'data' => $constellations['pleiades']
            ])
        </div>
    </div>
</section>

{{-- Principle Explanation --}}
<section class="principle-section" id="principe">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">
            Le Principe des 7 Ensemble
        </h2>

        <div class="principle-grid">
            <div class="principle-card" data-aos="fade-up" data-aos-delay="0">
                <div class="principle-icon">🌟</div>
                <h3>1. Rejoignez une Constellation</h3>
                <p>Entrez dans un groupe de 3 ou 7 personnes partageant le même objectif financier.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="100">
                <div class="principle-icon">💰</div>
                <h3>2. Investissement Initial</h3>
                <p>Commencez avec seulement 21€ pour débuter votre voyage à travers les 7 tours.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="200">
                <div class="principle-icon">🚀</div>
                <h3>3. Progression par Tours</h3>
                <p>Avancez à travers 7 tours successifs, chacun multipliant vos gains potentiels.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="300">
                <div class="principle-icon">⭐</div>
                <h3>4. L'Alcyone Reçoit</h3>
                <p>À chaque tour, une personne (l'Alcyone) reçoit les contributions du groupe.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="400">
                <div class="principle-icon">🔄</div>
                <h3>5. Rotation Continue</h3>
                <p>Chacun devient Alcyone à son tour, recevant le soutien de la constellation.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="500">
                <div class="principle-icon">💎</div>
                <h3>6. Gains Exponentiels</h3>
                <p>Vos gains augmentent exponentiellement à chaque tour complété avec succès.</p>
            </div>

            <div class="principle-card" data-aos="fade-up" data-aos-delay="600">
                <div class="principle-icon">🎯</div>
                <h3>7. Objectif Atteint</h3>
                <p>Après 7 tours, réalisez vos rêves financiers et aidez les autres à réussir.</p>
            </div>
        </div>
    </div>
</section>

{{-- Statistics Section --}}
@include('components.stats-cards', ['stats' => $stats])

{{-- Call to Action --}}
<section class="cta-section" data-aos="fade-up">
    <div class="container">
        <div class="cta-card">
            <h2>Prêt à Rejoindre la Révolution Financière ?</h2>
            <p>Des milliers de personnes ont déjà transformé leur vie. C'est votre tour.</p>
            <button onclick="openModal('sevenModal')" class="btn btn-primary btn-large">
                🚀 Commencer Maintenant
            </button>
        </div>
    </div>
</section>

@endsection

@push('modals')
{{-- Registration Modal --}}
@include('components.registration-modal', [
    'countries' => $countries,
    'paymentMethods' => $paymentMethods
])
@endpush

@push('scripts')
<script src="{{ asset('js/constellation-animation.js') }}"></script>
<script src="{{ asset('js/modal-handler.js') }}"></script>
<script src="{{ asset('js/number-animation.js') }}"></script>

{{-- Initialize AOS (Animate on Scroll) --}}
<script src="https://unpkg.com/aos@3.0.0-beta.6/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
    });
</script>
@endpush
