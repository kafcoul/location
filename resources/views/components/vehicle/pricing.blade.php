
<section class="vp-pricing-mobile">
    <div class="vp-pricing-mobile__inner">
        <div class="vp-pricing-mobile__header">
            <h3 class="vp-pricing-mobile__brand">{{ $vehicle->brand }}</h3>
            <h4 class="vp-pricing-mobile__model">{{ $vehicle->model ?? $vehicle->name }}</h4>
        </div>

        <div class="vp-pricing-mobile__block">
            <h5 class="vp-pricing-mobile__title">TARIFS (HT)</h5>

            <div class="vp-pricing-mobile__row">
                <span class="vp-pricing-mobile__label">Prix journalier</span>
                <span class="vp-pricing-mobile__value">{{ number_format($vehicle->price_per_day, 0, ',', ' ') }}{{ $currency }}</span>
            </div>

            @if($vehicle->km_price > 0)
                <div class="vp-pricing-mobile__row">
                    <span class="vp-pricing-mobile__label">Kilomètre parcouru</span>
                    <span class="vp-pricing-mobile__value">+{{ number_format($vehicle->km_price, 0, ',', ' ') }}{{ $currency }}</span>
                </div>
            @endif

            <div class="vp-pricing-mobile__row">
                <span class="vp-pricing-mobile__label">Caution</span>
                <span class="vp-pricing-mobile__value">{{ number_format($vehicle->deposit_amount, 0, ',', ' ') }}{{ $currency }}</span>
            </div>
        </div>

        @if($vehicle->weekly_price > 0 || $vehicle->monthly_classic_price > 0)
            <div class="vp-pricing-mobile__block">
                <h5 class="vp-pricing-mobile__title">ABONNEMENTS (HT)</h5>
                <p class="vp-pricing-mobile__note">Hebdo/mensuel · Sans engagement · Entretiens inclus</p>

                @if($vehicle->weekly_price > 0)
                    <div class="vp-pricing-mobile__row">
                        <span class="vp-pricing-mobile__label">Hebdomadaire <em>(1000km inclus)</em></span>
                        <span class="vp-pricing-mobile__value">{{ number_format($vehicle->weekly_price, 0, ',', ' ') }}{{ $currency }}</span>
                    </div>
                @endif

                @if($vehicle->monthly_classic_price > 0)
                    <div class="vp-pricing-mobile__row">
                        <span class="vp-pricing-mobile__label">Mensuel Classic <em>(2000km inclus)</em></span>
                        <span class="vp-pricing-mobile__value">{{ number_format($vehicle->monthly_classic_price, 0, ',', ' ') }}{{ $currency }}</span>
                    </div>
                @endif

                @if($vehicle->monthly_premium_price > 0)
                    <div class="vp-pricing-mobile__row">
                        <span class="vp-pricing-mobile__label">Mensuel Premium <em>(4000km inclus)</em></span>
                        <span class="vp-pricing-mobile__value">{{ number_format($vehicle->monthly_premium_price, 0, ',', ' ') }}{{ $currency }}</span>
                    </div>
                @endif
            </div>
        @endif

        <a href="{{ route('reservation.form', $vehicle->slug) }}" class="vp-pricing-mobile__cta">
            RÉSERVER
        </a>
    </div>
</section>
