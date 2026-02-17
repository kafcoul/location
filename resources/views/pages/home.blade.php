@extends('layouts.public')

@section('title', 'CKF Motors — Location de Voitures Premium à Abidjan')
@section('meta_description', 'Location de voitures premium à Abidjan. Réservez en ligne, paiement sur place.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<section class="hp-hero">
    <div class="hp-hero__bg">
        <img src="/images/abidjan-hero.jpg" alt="Location de voitures Abidjan">
    </div>
    <div class="hp-hero__overlay"></div>

    <div class="hp-hero__content">
        <span class="hp-hero__badge">Côte d'Ivoire</span>
        <p class="hp-hero__sub">Location de voitures premium</p>
        <h1 class="hp-hero__title">ABIDJAN</h1>
        <p class="hp-hero__desc">Découvrez notre flotte de véhicules haut de gamme disponibles à Abidjan. Réservation en ligne, livraison sur place.</p>
        <div class="hp-hero__actions">
            <a href="{{ route('city.show', 'abidjan') }}" class="hp-hero__cta hp-hero__cta--primary">Voir les véhicules</a>
            <a href="{{ route('accompagnement') }}" class="hp-hero__cta hp-hero__cta--outline">Notre accompagnement</a>
        </div>
    </div>
    <div class="hp-hero__scroll">
        <span></span>
    </div>
</section>

@endsection
