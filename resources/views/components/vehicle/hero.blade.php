
<section class="vehicule-hero">
        @if($mainImage)
        <div class="vehicule-hero__bg">
            <img src="{{ $mainImage }}" alt="{{ $vehicle->name }}" class="vehicule-hero__bg-img">
        </div>
    @endif

        <div class="vehicule-hero__overlay"></div>

        <div class="vehicule-hero__content">
        <h1 class="vehicule-hero__brand">{{ $vehicle->brand }}</h1>
        <h2 class="vehicule-hero__model">{{ $vehicle->model ?? $vehicle->name }}</h2>
        <p class="vehicule-hero__subtitle">Location de voitures {{ $cityLabel }}</p>
    </div>
</section>
