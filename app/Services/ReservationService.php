<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\ClientReservationReceivedNotification;
use App\Notifications\NewReservationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class ReservationService
{
    /**
     * Calcule le nombre de jours entre deux dates (min 1).
     */
    public function calculateDays(string|Carbon $start, string|Carbon $end): int
    {
        $days = Carbon::parse($start)->diffInDays(Carbon::parse($end));

        return max(1, (int) $days);
    }

    /**
     * Calcule l'estimation : jours × prix/jour.
     */
    public function estimateTotal(int $days, Vehicle $vehicle): int
    {
        return $days * $vehicle->price_per_day;
    }

    /**
     * Crée la réservation avec calculs automatiques.
     */
    public function create(array $data, Vehicle $vehicle): Reservation
    {
        $days  = $this->calculateDays($data['start_date'], $data['end_date']);
        $total = $this->estimateTotal($days, $vehicle);

        $reservation = Reservation::create([
            'vehicle_id'        => $vehicle->id,
            'full_name'         => $data['full_name'],
            'first_name'        => $data['first_name'] ?? null,
            'last_name'         => $data['last_name'] ?? null,
            'phone'             => $data['phone'],
            'email'             => $data['email'],
            'license_seniority' => $data['license_seniority'] ?? null,
            'birth_day'         => $data['birth_day'] ?? null,
            'birth_month'       => $data['birth_month'] ?? null,
            'birth_year'        => $data['birth_year'] ?? null,
            'start_date'        => $data['start_date'],
            'end_date'          => $data['end_date'],
            'total_days'        => $days,
            'estimated_total'   => $total,
            'status'            => Reservation::STATUS_PENDING,
            'notes'             => $data['notes'] ?? null,
        ]);

        // Charger la relation vehicle pour les notifications
        $reservation->load('vehicle');

        // Notifier tous les admins (database + mail)
        try {
            $admins = User::role([User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewReservationNotification($reservation));
            }
        } catch (\Throwable) {
            // Rôles non configurés — on continue sans notification admin
        }

        // Email de confirmation au client
        Notification::route('mail', $reservation->email)
            ->notify(new ClientReservationReceivedNotification($reservation));

        return $reservation;
    }
}
