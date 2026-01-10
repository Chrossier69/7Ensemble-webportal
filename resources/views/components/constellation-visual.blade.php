{{-- Constellation Visual Component --}}
<div class="constellation-card" data-aos="fade-up" data-aos-delay="{{ $type === 'triangulum' ? '0' : '200' }}">
    <div class="constellation-header">
        <h3>{{ $name }}</h3>
        <span class="member-count">{{ $members }} personnes</span>
    </div>

    {{-- Constellation Visualization with Orbit Animation --}}
    <div class="constellation-orbit-container" data-members="{{ $members }}" data-type="{{ $type }}">
        {{-- Center (Alcyone) --}}
        <div class="alcyone-center">
            <div class="alcyone-icon">⭐</div>
            <span class="alcyone-label">Alcyone</span>
        </div>

        {{-- Orbiting Members --}}
        <div class="orbit-ring">
            @for ($i = 1; $i <= $members; $i++)
                <div class="orbit-member" style="--member-index: {{ $i }}; --total-members: {{ $members }};">
                    <div class="member-icon">✨</div>
                </div>
            @endfor
        </div>

        {{-- Orbit Circle (visual guide) --}}
        <div class="orbit-circle"></div>
    </div>

    {{-- Transformation Arrow --}}
    <div class="transformation">
        <div class="amount-box initial">
            <span class="amount-label">Investissement</span>
            <span class="amount-value">{{ number_format($initial, 0, ',', ' ') }}€</span>
        </div>

        <div class="transformation-arrow">
            <span>→</span>
        </div>

        <div class="amount-box final">
            <span class="amount-label">Gains Totaux</span>
            <span class="amount-value highlight">
                <span class="animate-number" data-target="{{ $total }}">0</span>€
            </span>
        </div>
    </div>

    {{-- Benefits List --}}
    <div class="benefits-list">
        <div class="benefit-item">
            <span class="benefit-icon">✓</span>
            <span>{{ $members }} membres par constellation</span>
        </div>
        <div class="benefit-item">
            <span class="benefit-icon">✓</span>
            <span>7 tours de croissance</span>
        </div>
        <div class="benefit-item">
            <span class="benefit-icon">✓</span>
            <span>Entraide mutuelle garantie</span>
        </div>
    </div>

    {{-- CTA Button --}}
    <button onclick="openModal('{{ $type }}Modal')" class="btn btn-constellation">
        Rejoindre {{ $name }}
    </button>

    {{-- Badge --}}
    @if($type === 'pleiades')
        <div class="popular-badge">⭐ Populaire</div>
    @endif
</div>

<style>
.constellation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
    margin-top: 3rem;
}

.constellation-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2.5rem;
    position: relative;
    transition: all 0.4s;
}

.constellation-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    border-color: rgba(102, 126, 234, 0.5);
}

.constellation-header {
    text-align: center;
    margin-bottom: 2rem;
}

.constellation-header h3 {
    font-size: 2rem;
    color: #4ecdc4;
    margin-bottom: 0.5rem;
}

.member-count {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1rem;
}

/* Orbit Animation Container */
.constellation-orbit-container {
    width: 280px;
    height: 280px;
    margin: 2rem auto;
    position: relative;
}

.alcyone-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 10;
}

.alcyone-icon {
    font-size: 3rem;
    animation: pulse 2s ease-in-out infinite;
}

.alcyone-label {
    display: block;
    color: #f5576c;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.orbit-ring {
    width: 100%;
    height: 100%;
    position: relative;
    animation: rotate-orbit 20s linear infinite;
}

.orbit-circle {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 220px;
    height: 220px;
    border: 2px dashed rgba(78, 205, 196, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
}

.orbit-member {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    transform-origin: center;
}

.orbit-member .member-icon {
    font-size: 2rem;
    animation: counter-rotate 20s linear infinite;
}

/* Position members in a circle */
@for $i from 1 through 7 {
    .orbit-member:nth-child(#{$i}) {
        --angle: calc(360deg / var(--total-members) * (var(--member-index) - 1));
        transform: rotate(var(--angle)) translateY(-110px);
    }
}

@keyframes rotate-orbit {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes counter-rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(-360deg); }
}

/* Transformation Section */
.transformation {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin: 2rem 0;
}

.amount-box {
    flex: 1;
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.amount-label {
    display: block;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 0.5rem;
}

.amount-value {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
}

.amount-value.highlight {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.8rem;
}

.transformation-arrow {
    font-size: 2rem;
    color: #4ecdc4;
}

/* Benefits List */
.benefits-list {
    margin: 2rem 0;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    color: rgba(255, 255, 255, 0.9);
}

.benefit-icon {
    color: #4ecdc4;
    font-weight: bold;
    font-size: 1.2rem;
}

.btn-constellation {
    width: 100%;
    margin-top: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.popular-badge {
    position: absolute;
    top: -10px;
    right: 20px;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .constellation-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .constellation-orbit-container {
        width: 240px;
        height: 240px;
    }

    .orbit-circle {
        width: 180px;
        height: 180px;
    }

    .transformation {
        flex-direction: column;
    }

    .transformation-arrow {
        transform: rotate(90deg);
    }
}
</style>
