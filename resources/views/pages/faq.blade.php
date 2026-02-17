@extends('layouts.public')

@section('title', 'FAQ | CKF Motors')
@section('meta_description', 'Foire aux questions sur la location de voitures premium CKF Motors.')

@section('content')

<section class="relative h-[40vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1470&auto=format&fit=crop')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-black/70"></div>
    <div class="relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl font-bold tracking-tight uppercase">FAQ</h1>
    </div>
</section>

<section class="bg-brand-black py-16">
    <div class="max-w-3xl mx-auto px-6">

        @php
            $faqs = [
                ['q' => 'Qui sommes-nous ?', 'a' => 'CKF Motors est une agence de location de voitures premium opérant à Abidjan, en Côte d\'Ivoire. Nous mettons à votre disposition une flotte de véhicules haut de gamme avec un service d\'exception.'],
                ['q' => 'Où sommes-nous situés ?', 'a' => 'Nous opérons à Abidjan, en Côte d\'Ivoire. La remise et la restitution des véhicules se font à des points dédiés dans la ville.'],
                ['q' => 'Quelles sont les conditions à réunir pour réserver ?', 'a' => 'Vous devez être âgé d\'au moins 21 ans, être titulaire d\'un permis de conduire valide depuis au moins 2 ans et présenter une pièce d\'identité en cours de validité.'],
                ['q' => 'Comment réserver un véhicule ?', 'a' => 'Sélectionnez votre ville, choisissez votre véhicule, puis remplissez le formulaire de réservation. Notre équipe vous recontactera sous 24h pour confirmer la réservation.'],
                ['q' => 'Quels sont les documents demandés pour louer ?', 'a' => 'Permis de conduire valide, pièce d\'identité (CNI ou passeport), justificatif de domicile de moins de 3 mois, et un moyen de paiement pour la caution.'],
                ['q' => 'Quel est le montant de la caution ?', 'a' => 'Le montant de la caution varie selon le véhicule. Il est indiqué sur la fiche de chaque véhicule. La caution est restituée intégralement à la restitution du véhicule en bon état.'],
                ['q' => 'Comment fonctionne une pré-autorisation bancaire ?', 'a' => 'Une pré-autorisation est un blocage temporaire de fonds sur votre carte bancaire correspondant au montant de la caution. Le montant n\'est pas débité mais simplement réservé pendant la durée de la location.'],
                ['q' => 'Quelles sont les assurances incluses ?', 'a' => 'Tous nos véhicules sont assurés tous risques. Une franchise reste à la charge du locataire en cas de sinistre responsable.'],
                ['q' => 'Peut-on ajouter un conducteur supplémentaire ?', 'a' => 'Oui, il est possible d\'ajouter un conducteur supplémentaire. Celui-ci devra présenter les mêmes documents que le conducteur principal.'],
                ['q' => 'Proposez-vous la livraison du véhicule ?', 'a' => 'Oui, nous proposons la livraison et la récupération du véhicule à l\'adresse de votre choix (domicile, hôtel, aéroport) sous réserve de disponibilité. Des frais de livraison peuvent s\'appliquer.'],
                ['q' => 'Proposez-vous des formules de location longue durée ?', 'a' => 'Oui, nous proposons des formules hebdomadaires et mensuelles avec des tarifs préférentiels. Consultez la fiche du véhicule pour les tarifs détaillés.'],
                ['q' => 'Peut-on prolonger notre location ?', 'a' => 'Oui, sous réserve de disponibilité. Contactez-nous au moins 24h avant la fin de votre location pour prolonger.'],
                ['q' => 'Peut-on modifier ou annuler une réservation ?', 'a' => 'Oui, vous pouvez modifier ou annuler votre réservation gratuitement jusqu\'à 48h avant la date de début de location.'],
                ['q' => 'Que faire en cas de vol ou d\'accident ?', 'a' => 'En cas de vol ou d\'accident, contactez immédiatement les autorités compétentes puis notre service client. Un constat amiable devra être rempli en cas d\'accident.'],
            ];
        @endphp

        <div class="space-y-0">
            @foreach($faqs as $index => $faq)
                <div class="border-b border-white/10" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex justify-between items-center py-6 text-left group">
                        <span class="text-sm font-semibold uppercase tracking-wide group-hover:text-white/80 transition pr-8">{{ $faq['q'] }}</span>
                        <svg class="w-4 h-4 text-white/40 flex-shrink-0 transition-transform duration-300"
                             :class="{ 'rotate-45': open }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6">
                        <p class="text-sm text-white/50 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
