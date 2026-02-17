@extends('layouts.admin')

@section('title', 'Réservations — Admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Réservations</h1>

<div class="mb-4 flex gap-2 text-sm">
    <a href="{{ route('admin.reservations.index') }}"
       class="px-3 py-1 rounded {{ !request('status') ? 'bg-black text-white' : 'bg-gray-200' }}">Toutes</a>
    @foreach(['pending','confirmed','cancelled'] as $s)
        <a href="{{ route('admin.reservations.index', ['status' => $s]) }}"
           class="px-3 py-1 rounded {{ request('status') === $s ? 'bg-black text-white' : 'bg-gray-200' }}">{{ ucfirst($s) }}</a>
    @endforeach
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Client</th>
                <th class="px-4 py-2">Tél</th>
                <th class="px-4 py-2">Véhicule</th>
                <th class="px-4 py-2">Ville</th>
                <th class="px-4 py-2">Période</th>
                <th class="px-4 py-2">Jours</th>
                <th class="px-4 py-2">Estimation</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $r)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $r->id }}</td>
                    <td class="px-4 py-2">{{ $r->full_name }}</td>
                    <td class="px-4 py-2">{{ $r->phone }}</td>
                    <td class="px-4 py-2">{{ $r->vehicle->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $r->vehicle->city->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $r->start_date->format('d/m') }} → {{ $r->end_date->format('d/m') }}</td>
                    <td class="px-4 py-2">{{ $r->total_days }}</td>
                    <td class="px-4 py-2">{{ number_format($r->estimated_total, 0, ',', ' ') }}</td>
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
                <tr><td colspan="10" class="px-4 py-4 text-center text-gray-400">Aucune réservation.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reservations->appends(request()->query())->links() }}</div>

@endsection
