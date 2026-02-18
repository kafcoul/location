<?php

namespace App\Filament\Exports;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class ReservationPdfExport
{
    /**
     * Génère le PDF d'une seule réservation.
     */
    public static function single(Reservation $reservation): Response
    {
        $reservation->loadMissing('vehicle');

        $pdf = Pdf::loadView('pdf.reservation', compact('reservation'))
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Helvetica');

        $filename = 'reservation_' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Génère un PDF avec toutes les réservations (liste résumée).
     */
    public static function exportAll(?string $status = null): Response
    {
        $reservations = Reservation::query()
            ->with('vehicle:id,name,brand,model')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('pdf.reservations-list', compact('reservations', 'status'))
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Helvetica');

        $filename = 'reservations_' . ($status ?? 'toutes') . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
