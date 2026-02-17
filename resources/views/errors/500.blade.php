@extends('errors.layout')

@section('code', '500')
@section('title', 'Erreur serveur')
@section('description')
    {{ $message ?? 'Une erreur interne est survenue.' }}
    <br>Notre équipe technique a été notifiée. Veuillez réessayer dans quelques instants.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">
        ← Retour à l'accueil
    </a>
    <a href="javascript:location.reload()" class="btn btn-secondary">
        ↻ Réessayer
    </a>
@endsection
