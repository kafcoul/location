@extends('errors.layout')

@section('code', '404')
@section('title', 'Page introuvable')
@section('description')
    {{ $message ?? 'La page que vous cherchez n\'existe pas ou a été déplacée.' }}
    <br>Vérifiez l'URL ou retournez à l'accueil.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">
        ← Retour à l'accueil
    </a>
    <a href="{{ url('/ville/abidjan') }}" class="btn btn-secondary">
        Voir nos véhicules
    </a>
@endsection
