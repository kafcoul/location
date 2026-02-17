@extends('layouts.public')

@section('title', "Réservation — {{ $vehicle->name }} | CKF Motors")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endpush

@section('content')

@php
    $bgImage = $vehicle->image ? asset('storage/' . $vehicle->image) : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1600&q=80';
@endphp

<section class="rsv" style="background-image: url('{{ $bgImage }}')">
    <div class="rsv__overlay"></div>

    <div class="rsv__wrapper">

        <div class="rsv__left">
            <div class="rsv__left-content">
                <h1 class="rsv__title">DEMANDE DE RÉSERVATION</h1>
                <p class="rsv__subtitle">
                    Votre demande de confirmation sera traitée sous 24h.
                    Pour toute demande urgente, n'hésitez pas à nous contacter par téléphone au
                    <strong>01.34.67.00.82</strong>.
                </p>
                <a href="{{ route('vehicle.show', $vehicle->slug) }}" class="rsv__back-btn">Retour au véhicule</a>
            </div>
        </div>

        <div class="rsv__right">

            @if($errors->any())
                <div class="rsv__errors">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('reservation.store') }}" method="POST" class="rsv__form" id="rsvForm">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" id="vehicleIdInput">

                <div id="step1">
                    <div class="rsv__field">
                        <label class="rsv__label">Prénom *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required class="rsv__input">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Nom de famille *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required class="rsv__input">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">E‑mail *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="rsv__input">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Téléphone *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required class="rsv__input">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Ancienneté du permis *</label>
                        <select name="license_seniority" required class="rsv__input rsv__input--select">
                            <option value="" disabled {{ old('license_seniority') ? '' : 'selected' }}></option>
                            <option value="less_than_1" {{ old('license_seniority') == 'less_than_1' ? 'selected' : '' }}>Moins d'un an</option>
                            <option value="1_to_3" {{ old('license_seniority') == '1_to_3' ? 'selected' : '' }}>1 à 3 ans</option>
                            <option value="3_to_5" {{ old('license_seniority') == '3_to_5' ? 'selected' : '' }}>3 à 5 ans</option>
                            <option value="more_than_5" {{ old('license_seniority') == 'more_than_5' ? 'selected' : '' }}>Plus de 5 ans</option>
                        </select>
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Date de naissance *</label>
                        <div class="rsv__dob">
                            <div class="rsv__dob-col">
                                <span class="rsv__dob-label">Jour</span>
                                <select name="birth_day" required class="rsv__input rsv__input--select rsv__input--dob">
                                    <option value="" disabled {{ old('birth_day') ? '' : 'selected' }}></option>
                                    @for($d = 1; $d <= 31; $d++)
                                        <option value="{{ $d }}" {{ old('birth_day') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="rsv__dob-col">
                                <span class="rsv__dob-label">Mois</span>
                                <select name="birth_month" required class="rsv__input rsv__input--select rsv__input--dob">
                                    <option value="" disabled {{ old('birth_month') ? '' : 'selected' }}></option>
                                    @foreach(['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'] as $i => $m)
                                        <option value="{{ $i + 1 }}" {{ old('birth_month') == ($i + 1) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="rsv__dob-col">
                                <span class="rsv__dob-label">Année</span>
                                <select name="birth_year" required class="rsv__input rsv__input--select rsv__input--dob">
                                    <option value="" disabled {{ old('birth_year') ? '' : 'selected' }}></option>
                                    @for($y = date('Y') - 18; $y >= date('Y') - 80; $y--)
                                        <option value="{{ $y }}" {{ old('birth_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="rsv__btn-wrap">
                        <button type="button" class="rsv__btn" id="btnNext">Suivant</button>
                    </div>
                </div>

                <div id="step2" style="display:none;">
                    <div class="rsv__field">
                        <label class="rsv__label">Choix du véhicule *</label>
                        <select id="vehicleSelect" class="rsv__input rsv__input--select">
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" {{ $v->id == $vehicle->id ? 'selected' : '' }}>{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Début de location *</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}" class="rsv__input rsv__input--date">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Fin de location *</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required class="rsv__input rsv__input--date">
                    </div>

                    <div class="rsv__field">
                        <label class="rsv__label">Précisions</label>
                        <textarea name="notes" rows="4" class="rsv__textarea">{{ old('notes') }}</textarea>
                    </div>

                    <div class="rsv__btn-wrap rsv__btn-wrap--between">
                        <button type="button" class="rsv__btn rsv__btn--outline" id="btnBack">Retour</button>
                        <button type="submit" class="rsv__btn">Envoyer</button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</section>

@push('scripts')
<script>
    var step1 = document.getElementById('step1');
    var step2 = document.getElementById('step2');
    var btnNext = document.getElementById('btnNext');
    var btnBack = document.getElementById('btnBack');
    var vehicleSelect = document.getElementById('vehicleSelect');
    var vehicleIdInput = document.getElementById('vehicleIdInput');

    btnNext.addEventListener('click', function() {
        var inputs = step1.querySelectorAll('[required]');
        var valid = true;
        for (var i = 0; i < inputs.length; i++) {
            if (!inputs[i].value) {
                inputs[i].focus();
                valid = false;
                break;
            }
        }
        if (!valid) return;
        step1.style.display = 'none';
        step2.style.display = 'block';
        step2.style.opacity = '0';
        step2.style.transform = 'translateX(20px)';
        setTimeout(function() {
            step2.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            step2.style.opacity = '1';
            step2.style.transform = 'translateX(0)';
        }, 10);
    });

    btnBack.addEventListener('click', function() {
        step2.style.display = 'none';
        step1.style.display = 'block';
        step1.style.opacity = '0';
        step1.style.transform = 'translateX(-20px)';
        setTimeout(function() {
            step1.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            step1.style.opacity = '1';
            step1.style.transform = 'translateX(0)';
        }, 10);
    });

    vehicleSelect.addEventListener('change', function() {
        vehicleIdInput.value = this.value;
    });
</script>
@endpush

@endsection
