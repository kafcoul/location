@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        <p class="text-sm text-gray-500">En attente</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-3xl font-bold text-green-600">{{ $stats['confirmed'] }}</div>
        <p class="text-sm text-gray-500">Confirmées</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-3xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
        <p class="text-sm text-gray-500">Annulées</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-3xl font-bold text-gray-700">{{ $stats['total'] }}</div>
        <p class="text-sm text-gray-500">Total</p>
    </div>
</div>

<h2 class="text-lg font-semibold mb-3">Dernières demandes</h2>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Client</th>
                <th class="px-4 py-2">Véhicule</th>
                <th class="px-4 py-2">Période</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent as $r)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $r->id }}</td>
                    <td class="px-4 py-2">{{ $r->full_name }}</td>
                    <td class="px-4 py-2">{{ $r->vehicle->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $r->start_date->format('d/m') }} → {{ $r->end_date->format('d/m') }}</td>
                    <td class="px-4 py-2">
                        @if($r->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs">Pending</span>
                        @elseif($r->status === 'confirmed')
                            <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs">Confirmed</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="text-blue-600 hover:underline text-xs">Détails</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-4 text-center text-gray-400">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
