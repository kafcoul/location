@extends('errors.layout')

@section('code', '419')
@section('title', 'Session expirée')
@section('description')
    {{ $message ?? 'Votre session a expiré pour des raisons de sécurité.' }}
    <br>Veuillez rafraîchir la page et réessayer.
@endsection

@section('actions')
    <a href="javascript:location.reload()" class="btn btn-primary">
        ↻ Rafraîchir la page
    </a>
    <a href="{{ url('/') }}" class="btn btn-secondary">
        ← Retour à l'accueil
    </a>
@endsection
