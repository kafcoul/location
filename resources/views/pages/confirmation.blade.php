@extends('layouts.public')

@section('title', 'Réservation confirmée | CKF Motors')

@section('content')

<section class="min-h-screen bg-brand-black py-20">
    <div class="max-w-xl mx-auto px-6 text-center">

                <div class="w-16 h-16 border-2 border-white rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold tracking-tight uppercase mb-4">Demande enregistrée</h1>
        <p class="text-sm text-white/50 mb-10 leading-relaxed">
            Merci <strong class="text-white">{{ $reservation->full_name }}</strong>.<br>
            Nous vous contacterons rapidement pour confirmer votre réservation.<br>
            Le paiement s'effectue sur place.
        </p>

                <div class="border border-white/10 p-8 text-left space-y-4 text-sm">
            <div class="price-row">
                <span class="price-label">Véhicule</span>
                <span class="font-semibold">{{ $reservation->vehicle->name }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">Ville</span>
                <span class="font-semibold">{{ $reservation->vehicle->city->name }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">Du</span>
                <span class="font-semibold">{{ $reservation->start_date->format('d/m/Y') }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">Au</span>
                <span class="font-semibold">{{ $reservation->end_date->format('d/m/Y') }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">Durée</span>
                <span class="font-semibold">{{ $reservation->total_days }} jour(s)</span>
            </div>
            <div class="price-row">
                <span class="price-label">Estimation</span>
                <span class="font-bold text-lg">{{ number_format($reservation->estimated_total, 0, ',', ' ') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2">
                <span class="text-xs uppercase tracking-wider text-brand-muted">Statut</span>
                <span class="text-xs uppercase tracking-widest bg-white/10 px-3 py-1">En attente</span>
            </div>
        </div>

                <a href="{{ route('home') }}"
           class="inline-block mt-10 border-2 border-white text-sm tracking-[0.2em] uppercase font-semibold px-10 py-4 hover:bg-white hover:text-black transition-all duration-300">
            Retour à l'accueil
        </a>
    </div>
</section>

@endsection
