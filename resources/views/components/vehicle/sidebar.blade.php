
<aside class="vp-card">
    {{-- En-tête : Marque + Modèle --}}
    <div class="vp-card__header">
        <h2 class="vp-card__brand">{{ $vehicle->brand }}</h2>
        <p class="vp-card__model">{{ $vehicle->model ?? $vehicle->name }}</p>
    </div>

    {{-- Miniature --}}
    @if($mainImage)
        <div class="vp-card__thumb">
            <img src="{{ $mainImage }}" alt="{{ $vehicle->name }}">
        </div>
    @endif

    {{-- Tarifs --}}
    <div class="vp-card__section">
        <h5 class="vp-card__section-title">TARIFS (HT)</h5>

        <div class="vp-card__row">
            <span class="vp-card__label">Prix journalier</span>
            <span class="vp-card__value">{{ number_format($vehicle->price_per_day, 0, ',', ' ') }}{{ $currency }}</span>
        </div>

        @if($vehicle->km_price > 0)
            <div class="vp-card__row">
                <span class="vp-card__label">Kilomètre parcouru</span>
                <span class="vp-card__value">+{{ number_format($vehicle->km_price, 0, ',', ' ') }}{{ $currency }}</span>
            </div>
        @endif

        <div class="vp-card__row">
            <span class="vp-card__label">Caution</span>
            <span class="vp-card__value">{{ number_format($vehicle->deposit_amount, 0, ',', ' ') }}{{ $currency }}</span>
        </div>
    </div>

    {{-- Abonnements --}}
    @if($vehicle->weekly_price > 0 || $vehicle->monthly_classic_price > 0)
        <div class="vp-card__section">
            <h5 class="vp-card__section-title">ABONNEMENTS (HT)</h5>
            <p class="vp-card__subtitle">Hebdo/mensuel · Sans engagement · Entretiens inclus</p>

            @if($vehicle->weekly_price > 0)
                <div class="vp-card__row">
                    <span class="vp-card__label">Hebdomadaire <em>(1000km inclus)</em></span>
                    <span class="vp-card__value">{{ number_format($vehicle->weekly_price, 0, ',', ' ') }}{{ $currency }}</span>
                </div>
            @endif

            @if($vehicle->monthly_classic_price > 0)
                <div class="vp-card__row">
                    <span class="vp-card__label">Mensuel Classic <em>(2000km inclus)</em></span>
                    <span class="vp-card__value">{{ number_format($vehicle->monthly_classic_price, 0, ',', ' ') }}{{ $currency }}</span>
                </div>
            @endif

            @if($vehicle->monthly_premium_price > 0)
                <div class="vp-card__row">
                    <span class="vp-card__label">Mensuel Premium <em>(4000km inclus)</em></span>
                    <span class="vp-card__value">{{ number_format($vehicle->monthly_premium_price, 0, ',', ' ') }}{{ $currency }}</span>
                </div>
            @endif
        </div>
    @endif

    {{-- CTA --}}
    <a href="{{ route('reservation.form', $vehicle->slug) }}" class="vp-card__cta">
        RÉSERVER
    </a>
</aside>
