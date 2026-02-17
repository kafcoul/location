@extends('layouts.admin')

@section('title', 'Véhicules — Admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Véhicules</h1>
    <a href="{{ route('admin.vehicles.create') }}" class="bg-black text-white px-4 py-2 rounded text-sm hover:bg-gray-800">+ Ajouter</a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-2">Ville</th>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prix/jour</th>
                <th class="px-4 py-2">Caution</th>
                <th class="px-4 py-2">Dispo</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $v)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $v->city->name ?? '—' }}</td>
                    <td class="px-4 py-2 font-medium">{{ $v->name }}</td>
                    <td class="px-4 py-2">{{ number_format($v->price_per_day, 0, ',', ' ') }}</td>
                    <td class="px-4 py-2">{{ number_format($v->deposit_amount, 0, ',', ' ') }}</td>
                    <td class="px-4 py-2">
                        @if($v->is_available)
                            <span class="text-green-600 font-semibold">✓</span>
                        @else
                            <span class="text-red-500 font-semibold">✗</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.vehicles.edit', $v) }}" class="text-blue-600 hover:underline text-xs">Éditer</a>
                        <form action="{{ route('admin.vehicles.destroy', $v) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce véhicule ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Suppr.</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-4 text-center text-gray-400">Aucun véhicule.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $vehicles->links() }}</div>

@endsection
