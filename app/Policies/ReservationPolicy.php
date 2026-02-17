<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;

class ReservationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_reservations');
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return $user->can('view_reservations');
    }

    public function create(User $user): bool
    {
        return $user->can('create_reservations');
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->can('edit_reservations');
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->can('delete_reservations');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_reservations');
    }

    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Reservation $reservation): bool
    {
        return $user->can('edit_reservations');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('edit_reservations');
    }

    public function confirm(User $user, Reservation $reservation): bool
    {
        return $user->can('confirm_reservations');
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->can('cancel_reservations');
    }
}
