@extends('errors.layout')

@section('code', '503')
@section('title', 'Maintenance en cours')
@section('description')
    CKF Motors est en maintenance pour améliorer votre expérience.
    <br>Nous serons de retour très bientôt. Merci de votre patience.
@endsection

@section('actions')
    <a href="javascript:location.reload()" class="btn btn-primary">
        ↻ Vérifier la disponibilité
    </a>
@endsection
