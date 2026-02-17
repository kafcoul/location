<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class AdminNotificationObserver
{
    /**
     * Réservation annulée → notification admin.
     */
    public function updated(Reservation $reservation): void
    {
        if (!$reservation->wasChanged('status')) {
            return;
        }

        if ($reservation->status === 'cancelled') {
            $reservation->loadMissing('vehicle');

            $this->notifyAdmins(
                Notification::make()
                    ->title('Réservation #' . $reservation->id . ' annulée')
                    ->body($reservation->full_name . ' — ' . ($reservation->vehicle?->name ?? 'Véhicule') . ' — ' . number_format($reservation->estimated_total, 0, ',', '.') . ' FCFA')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->actions([
                        Action::make('view')
                            ->label('Voir')
                            ->url("/admin/reservations/{$reservation->id}/edit")
                            ->button(),
                    ])
            );
        }
    }

    /**
     * Nouvelle réservation → notification admin.
     */
    public function created(Reservation $reservation): void
    {
        $reservation->loadMissing('vehicle');

        $this->notifyAdmins(
            Notification::make()
                ->title('Nouvelle réservation #' . $reservation->id)
                ->body($reservation->full_name . ' — ' . ($reservation->vehicle?->name ?? 'Véhicule') . ' — ' . number_format($reservation->estimated_total, 0, ',', '.') . ' FCFA')
                ->icon('heroicon-o-calendar-days')
                ->iconColor('warning')
                ->actions([
                    Action::make('view')
                        ->label('Voir')
                        ->url("/admin/reservations/{$reservation->id}/edit")
                        ->button(),
                ])
        );
    }

    /**
     * Envoie une notification Filament database à tous les admins.
     */
    private function notifyAdmins(Notification $notification): void
    {
        $admins = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Super Admin', 'Admin', 'Manager']);
        })->get();

        foreach ($admins as $admin) {
            $notification->sendToDatabase($admin);
        }
    }
}
