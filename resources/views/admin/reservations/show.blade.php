@extends('layouts.admin')

@section('title', "Réservation #{{ $reservation->id }} — Admin")

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.reservations.index') }}" class="text-sm text-gray-500 hover:underline mb-4 inline-block">← Retour</a>

    <h1 class="text-2xl font-bold mb-6">Réservation #{{ $reservation->id }}</h1>

    <div class="bg-white rounded-lg shadow p-6 space-y-3 text-sm">
        <p><span class="font-semibold w-32 inline-block">Client :</span> {{ $reservation->full_name }}</p>
        <p><span class="font-semibold w-32 inline-block">Téléphone :</span> {{ $reservation->phone }}</p>
        <p><span class="font-semibold w-32 inline-block">Email :</span> {{ $reservation->email }}</p>
        <hr>
        <p><span class="font-semibold w-32 inline-block">Véhicule :</span> {{ $reservation->vehicle->name ?? '—' }}</p>
        <p><span class="font-semibold w-32 inline-block">Ville :</span> {{ $reservation->vehicle->city->name ?? '—' }}</p>
        <hr>
        <p><span class="font-semibold w-32 inline-block">Du :</span> {{ $reservation->start_date->format('d/m/Y') }}</p>
        <p><span class="font-semibold w-32 inline-block">Au :</span> {{ $reservation->end_date->format('d/m/Y') }}</p>
        <p><span class="font-semibold w-32 inline-block">Durée :</span> {{ $reservation->total_days }} jour(s)</p>
        <p><span class="font-semibold w-32 inline-block">Estimation :</span> <strong class="text-green-700">{{ number_format($reservation->estimated_total, 0, ',', ' ') }}</strong></p>
        <hr>
        <p><span class="font-semibold w-32 inline-block">Statut :</span>
            @if($reservation->status === 'pending')
                <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs">Pending</span>
            @elseif($reservation->status === 'confirmed')
                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs">Confirmed</span>
            @else
                <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs">Cancelled</span>
            @endif
        </p>
        @if($reservation->notes)
            <p><span class="font-semibold w-32 inline-block">Notes :</span> {{ $reservation->notes }}</p>
        @endif
        <p class="text-xs text-gray-400">Créée le {{ $reservation->created_at->format('d/m/Y H:i') }}</p>
    </div>

        <div class="mt-6 flex gap-2">
        @if($reservation->status !== 'confirmed')
            <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="confirmed">
                <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">✓ Confirmer</button>
            </form>
        @endif

        @if($reservation->status !== 'cancelled')
            <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" onsubmit="return confirm('Annuler cette réservation ?')">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">✗ Annuler</button>
            </form>
        @endif
    </div>
</div>

@endsection
