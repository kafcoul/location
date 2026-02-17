<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class NewReservationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public array $backoff = [10, 60, 300];
    public int $timeout = 30;

    public function __construct(
        public readonly Reservation $reservation,
    ) {
        $this->onQueue('notifications');
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $r = $this->reservation;

        return (new MailMessage)
            ->subject('🚗 Nouvelle réservation #' . $r->id)
            ->greeting('Nouvelle réservation !')
            ->line("**Client :** {$r->full_name}")
            ->line("**Email :** {$r->email}")
            ->line("**Téléphone :** {$r->phone}")
            ->line("**Véhicule :** {$r->vehicle?->name}")
            ->line("**Période :** {$r->start_date->format('d/m/Y')} → {$r->end_date->format('d/m/Y')} ({$r->total_days} jours)")
            ->line("**Total estimé :** " . number_format($r->estimated_total, 0, ',', '.') . ' FCFA')
            ->action('Voir dans l\'admin', url('/admin/reservations/' . $r->id . '/edit'))
            ->salutation('— CKF Motors');
    }

    public function toDatabase(object $notifiable): array
    {
        $r = $this->reservation;

        return FilamentNotification::make()
            ->title('Nouvelle réservation #' . $r->id)
            ->body("{$r->full_name} — {$r->vehicle?->name} — " . number_format($r->estimated_total, 0, ',', '.') . ' FCFA')
            ->icon('heroicon-o-calendar-days')
            ->iconColor('warning')
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label('Voir')
                    ->url("/admin/reservations/{$r->id}/edit")
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'client'         => $this->reservation->full_name,
            'vehicle'        => $this->reservation->vehicle?->name,
            'total'          => $this->reservation->estimated_total,
            'message'        => "Nouvelle réservation de {$this->reservation->full_name}",
        ];
    }
}
