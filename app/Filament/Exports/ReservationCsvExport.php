<?php

namespace App\Filament\Exports;

use App\Models\Reservation;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReservationCsvExport
{
    /**
     * Exporte les réservations filtrées en CSV.
     */
    public static function export(?string $status = null): StreamedResponse
    {
        $filename = 'reservations_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($status) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 pour Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // En-têtes
            fputcsv($handle, [
                '#',
                'Client',
                'Email',
                'Téléphone',
                'Véhicule',
                'Début',
                'Fin',
                'Jours',
                'Total (FCFA)',
                'Statut',
                'Date création',
            ], ';');

            // Données
            Reservation::query()
                ->with('vehicle:id,name')
                ->when($status, fn ($q) => $q->where('status', $status))
                ->orderByDesc('created_at')
                ->chunk(500, function (Collection $reservations) use ($handle) {
                    foreach ($reservations as $r) {
                        fputcsv($handle, [
                            $r->id,
                            $r->full_name,
                            $r->email,
                            $r->phone,
                            $r->vehicle?->name ?? '—',
                            $r->start_date->format('d/m/Y'),
                            $r->end_date->format('d/m/Y'),
                            $r->total_days,
                            number_format($r->estimated_total, 0, ',', '.'),
                            match ($r->status) {
                                'pending'   => 'En attente',
                                'confirmed' => 'Confirmée',
                                'cancelled' => 'Annulée',
                                default     => $r->status,
                            },
                            $r->created_at->format('d/m/Y H:i'),
                        ], ';');
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
