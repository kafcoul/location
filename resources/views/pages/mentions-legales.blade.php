@extends('layouts.public')

@section('title', 'Mentions Légales — CKF Motors')
@section('meta_description', 'Mentions légales du site CKF Motors, location de véhicules premium à Abidjan.')

@section('content')
<div class="min-h-screen pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-6 lg:px-12">

        <h1 class="text-3xl md:text-4xl font-bold tracking-wider uppercase mb-4">Mentions Légales</h1>
        <div class="w-16 h-px bg-brand-gold mb-12"></div>

        <div class="space-y-10 text-sm text-white/70 leading-relaxed">

            {{-- Éditeur --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">1. Éditeur du site</h2>
                <p>
                    Le site <strong class="text-white">ckfmotors.com</strong> est édité par :<br>
                    <strong class="text-white">CKF Motors</strong><br>
                    Siège social : Cocody Angré, Abidjan, Côte d'Ivoire<br>
                    Téléphone : <a href="tel:+2250700000000" class="text-brand-gold hover:underline">+225 07 00 00 00 00</a><br>
                    Email : <a href="mailto:contact@ckfmotors.com" class="text-brand-gold hover:underline">contact@ckfmotors.com</a>
                </p>
            </section>

            {{-- Hébergement --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">2. Hébergement</h2>
                <p>
                    Le site est hébergé par :<br>
                    Nom de l'hébergeur, adresse, téléphone.<br>
                    <span class="text-white/40 italic">(À compléter avec les informations de votre hébergeur)</span>
                </p>
            </section>

            {{-- Propriété intellectuelle --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">3. Propriété intellectuelle</h2>
                <p>
                    L'ensemble du contenu du site CKF Motors (textes, images, logo, vidéos, graphismes, icônes) est protégé par les lois relatives à la propriété intellectuelle.
                    Toute reproduction, représentation, modification, publication ou adaptation de tout ou partie des éléments du site est interdite sans l'accord écrit préalable de CKF Motors.
                </p>
            </section>

            {{-- Données personnelles --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">4. Protection des données personnelles</h2>
                <p>
                    CKF Motors s'engage à protéger les données personnelles de ses utilisateurs. Les informations recueillies via les formulaires de réservation sont utilisées uniquement dans le cadre de la gestion des locations et ne sont pas transmises à des tiers.
                </p>
                <p class="mt-3">
                    Conformément à la loi n°2013-450 du 19 juin 2013 relative à la protection des données à caractère personnel en Côte d'Ivoire, vous disposez d'un droit d'accès, de rectification et de suppression de vos données en contactant : <a href="mailto:contact@ckfmotors.com" class="text-brand-gold hover:underline">contact@ckfmotors.com</a>
                </p>
            </section>

            {{-- Cookies --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">5. Cookies</h2>
                <p>
                    Le site utilise des cookies nécessaires au bon fonctionnement du site et à l'amélioration de l'expérience utilisateur. En naviguant sur ce site, vous acceptez l'utilisation de ces cookies.
                </p>
            </section>

            {{-- Responsabilité --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">6. Limitation de responsabilité</h2>
                <p>
                    CKF Motors s'efforce de fournir des informations précises et à jour sur le site. Toutefois, CKF Motors ne peut garantir l'exactitude, la complétude ou l'actualité des informations diffusées. Les tarifs et disponibilités des véhicules sont donnés à titre indicatif et peuvent être modifiés sans préavis.
                </p>
            </section>

            {{-- Droit applicable --}}
            <section>
                <h2 class="text-lg font-semibold text-white mb-3 tracking-wide uppercase">7. Droit applicable</h2>
                <p>
                    Les présentes mentions légales sont régies par le droit ivoirien. Tout litige relatif à l'utilisation du site sera soumis à la compétence exclusive des tribunaux d'Abidjan.
                </p>
            </section>

        </div>

        <div class="mt-16 pt-8 border-t border-white/10 text-xs text-white/30">
            Dernière mise à jour : {{ now()->translatedFormat('F Y') }}
        </div>
    </div>
</div>
@endsection
