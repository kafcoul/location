@extends('layouts.admin')

@section('title', 'Ajouter un véhicule — Admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Ajouter un véhicule</h1>

@include('admin.vehicles._form', ['vehicle' => null])

@endsection
