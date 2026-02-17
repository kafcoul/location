@extends('layouts.public')

@section('title', 'Accompagnement — CKF Motors')
@section('meta_description', "Découvrez l'accompagnement le plus complet pour créer votre agence de location de voitures premium. Méthode éprouvée, experts confirmés, suivi d'un an.")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/accompagnement.css') }}">
@endpush

@section('content')

    @include('components.accompagnement.method')

    @include('components.accompagnement.hero')

    @include('components.accompagnement.dream')

    @include('components.accompagnement.positioning')

    @include('components.accompagnement.offers')

    @include('components.accompagnement.advantages')

    @include('components.accompagnement.team')

    @include('components.accompagnement.program')

<script>
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const hero = document.getElementById('accHero');
    if (hero) requestAnimationFrame(() => hero.classList.add('is-loaded'));

    const els = document.querySelectorAll('.acc-reveal');
    if (els.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        els.forEach((el, i) => {
            el.style.transitionDelay = `${(i % 4) * 0.1}s`;
            el.classList.add('v-reveal-ready');
            observer.observe(el);
        });

        // Fallback
        setTimeout(() => {
            els.forEach(el => {
                if (!el.classList.contains('is-visible')) el.classList.add('is-visible');
            });
        }, 2500);
    }

    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
</script>

@endsection
