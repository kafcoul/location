@extends('layouts.public')

@section('title', "{$vehicle->brand} {$vehicle->model} — Location à {$vehicle->city->name} | CKF Motors")
@section('meta_description', "Louez la {$vehicle->name} à {$vehicle->city->name}. {$vehicle->price_per_day} / jour. Paiement sur place.")
@section('body-class', 'vp-body')
@section('og_type', 'product')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vehicule.css') }}?v={{ time() }}">
@endpush

@php
    $currency      = ' FCFA';
    $galleryImages = $vehicle->gallery ?? [];
    $allImages     = [];
    if ($vehicle->image) {
        $allImages[] = asset('storage/' . $vehicle->image);
    }
    foreach ($galleryImages as $img) {
        $allImages[] = asset('storage/' . $img);
    }
    if (empty($allImages)) {
        $allImages[] = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=1200&q=80';
    }
    $mainImage = $allImages[0] ?? null;
    $details   = $vehicle->details ?? [];
@endphp

@section('og_image', $mainImage)

@section('content')
<div class="vp-page">

{{-- Hero plein écran --}}
@include('components.vehicle.hero', [
    'vehicle'   => $vehicle,
    'mainImage' => $mainImage,
    'cityLabel' => $vehicle->city->name ?? 'Abidjan',
])

{{-- Section principale : Galerie + Sidebar --}}
<section class="vp-main">
    <div class="vp-main__container">

        {{-- Colonne gauche : Galerie + Titre + Specs + Description --}}
        <div class="vp-main__gallery">
            @include('components.vehicle.gallery', [
                'vehicle'   => $vehicle,
                'allImages' => $allImages,
            ])

            {{-- Titre + Spécifications directement sous la galerie --}}
            <div class="vp-info">
                <div class="vp-info__header">
                    <h1 class="vp-info__brand">{{ $vehicle->brand }}</h1>
                    <p class="vp-info__model">{{ $vehicle->model }}</p>
                </div>

                @include('components.vehicle.specs', ['vehicle' => $vehicle])
            </div>

            {{-- Description + Détails --}}
            <div class="vp-description-inline">
                @if($vehicle->description)
                    <div class="vp-description__text">
                        {{ $vehicle->description }}
                    </div>
                @endif

                @foreach($details as $sectionTitle => $items)
                    <div class="vp-description__section">
                        <h5 class="vp-description__section-title">{{ $sectionTitle }}</h5>
                        <ul class="vp-description__list">
                            @foreach($items as $item)
                                <li class="vp-description__list-item">
                                    <span class="vp-description__bullet"></span>
                                    <span>{!! preg_replace('/^([^:]+\s*:)/', '<strong>$1</strong>', e($item)) !!}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Colonne droite : Carte tarifs --}}
        <div class="vp-main__sidebar">
            @include('components.vehicle.sidebar', [
                'vehicle'   => $vehicle,
                'currency'  => $currency,
                'mainImage' => $mainImage,
            ])
        </div>

    </div>
</section>

{{-- Pricing mobile uniquement --}}
@include('components.vehicle.pricing', [
    'vehicle'  => $vehicle,
    'currency' => $currency,
])

</div>{{-- fin .vp-page --}}

<script src="{{ asset('js/vehicule.js') }}?v={{ time() }}"></script>

@endsection