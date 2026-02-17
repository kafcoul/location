<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientReservationReceivedNotification extends Notification implements ShouldQueue
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
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $r = $this->reservation;

        return (new MailMessage)
            ->subject('📋 Demande reçue — CKF Motors')
            ->greeting("Bonjour {$r->full_name},")
            ->line('Nous avons bien reçu votre demande de réservation.')
            ->line("**Véhicule :** {$r->vehicle?->name}")
            ->line("**Du** {$r->start_date->format('d/m/Y')} **au** {$r->end_date->format('d/m/Y')}")
            ->line("**Durée :** {$r->total_days} jour(s)")
            ->line("**Total estimé :** " . number_format($r->estimated_total, 0, ',', '.') . ' FCFA')
            ->line('')
            ->line('Notre équipe va traiter votre demande dans les plus brefs délais.')
            ->line('Vous recevrez un email de confirmation dès validation.')
            ->salutation('Cordialement, l\'équipe CKF Motors — Abidjan');
    }
}
