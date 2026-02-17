@extends('layouts.admin')

@section('title', 'Modifier véhicule — Admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Modifier : {{ $vehicle->name }}</h1>

@include('admin.vehicles._form', ['vehicle' => $vehicle])

@endsection
