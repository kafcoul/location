<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_vehicles');
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->can('view_vehicles');
    }

    public function create(User $user): bool
    {
        return $user->can('create_vehicles');
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->can('edit_vehicles');
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->can('delete_vehicles');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_vehicles');
    }

    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Vehicle $vehicle): bool
    {
        return $user->can('edit_vehicles');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('edit_vehicles');
    }
}
