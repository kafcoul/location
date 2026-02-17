<?php

namespace App\Filament\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VehicleCsvExport
{
    public static function export(): StreamedResponse
    {
        $filename = 'vehicules_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                '#',
                'Nom',
                'Marque',
                'Modèle',
                'Ville',
                'Prix/jour (FCFA)',
                'Caution (FCFA)',
                'Boîte',
                'Carburant',
                'Places',
                'Disponible',
                'Réservations',
            ], ';');

            Vehicle::query()
                ->with('city:id,name')
                ->withCount('reservations')
                ->orderBy('name')
                ->chunk(500, function (Collection $vehicles) use ($handle) {
                    foreach ($vehicles as $v) {
                        fputcsv($handle, [
                            $v->id,
                            $v->name,
                            $v->brand ?? '—',
                            $v->model ?? '—',
                            $v->city?->name ?? '—',
                            number_format($v->price_per_day, 0, ',', '.'),
                            number_format($v->deposit_amount, 0, ',', '.'),
                            $v->gearbox,
                            $v->fuel,
                            $v->seats,
                            $v->is_available ? 'Oui' : 'Non',
                            $v->reservations_count,
                        ], ';');
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
