@extends('layouts.public')

@section('title', "Location premium à {{ $city->name }} | CKF Motors")
@section('meta_description', "Louez un véhicule premium à {{ $city->name }}. Prix par jour affichés, paiement sur place.")

@section('content')

@php
    $currency = ' FCFA';
@endphp

<section class="city-section">
    <div class="city-inner">

        @if($vehicles->isEmpty())
            <p class="city-empty">Aucun véhicule disponible pour le moment.</p>
        @else
            <div class="city-grid" id="vehicle-grid">

                @foreach($vehicles as $index => $vehicle)
                    <a href="{{ route('vehicle.show', $vehicle->slug) }}"
                       class="city-card"
                       style="animation-delay: {{ $index * 100 }}ms">

                        @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}"
                                 alt="{{ $vehicle->name }}"
                                 class="city-card__img"
                                 loading="lazy">
                        @else
                            <div class="city-card__placeholder"></div>
                        @endif

                        <div class="city-card__price">
                            {{ number_format($vehicle->price_per_day, 0, ',', ' ') }}{{ $currency }}<span>/jour</span>
                        </div>

                        <div class="city-card__overlay"></div>

                        <div class="city-card__bottom">
                            <div class="city-card__text">
                                <p class="city-card__brand">{{ $vehicle->brand ?? '' }}</p>
                                <h3 class="city-card__model">{{ $vehicle->model ?? $vehicle->name }}</h3>
                            </div>
                            <span class="city-card__cta">Réserver</span>
                        </div>

                    </a>
                @endforeach

            </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -40px 0px', threshold: 0.05 });

    document.querySelectorAll('.city-card').forEach((card) => observer.observe(card));
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/city.css') }}">
@endpush

@endsection
