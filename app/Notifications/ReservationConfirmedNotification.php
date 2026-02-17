<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationConfirmedNotification extends Notification implements ShouldQueue
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
            ->subject('✅ Réservation confirmée — CKF Motors')
            ->greeting("Bonjour {$r->full_name},")
            ->line('Votre réservation a été **confirmée** avec succès !')
            ->line("**Véhicule :** {$r->vehicle?->name}")
            ->line("**Du** {$r->start_date->format('d/m/Y')} **au** {$r->end_date->format('d/m/Y')}")
            ->line("**Durée :** {$r->total_days} jour(s)")
            ->line("**Total estimé :** " . number_format($r->estimated_total, 0, ',', '.') . ' FCFA')
            ->line('')
            ->line('Notre équipe vous contactera sous peu pour organiser la remise du véhicule.')
            ->line('Pour toute question, contactez-nous par téléphone ou WhatsApp.')
            ->salutation('Cordialement, l\'équipe CKF Motors — Abidjan');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message'        => 'Réservation confirmée',
        ];
    }
}
