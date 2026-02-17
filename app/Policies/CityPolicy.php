<?php

namespace App\Policies;

use App\Models\User;
use App\Models\City;

class CityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_cities');
    }

    public function view(User $user, City $city): bool
    {
        return $user->can('view_cities');
    }

    public function create(User $user): bool
    {
        return $user->can('create_cities');
    }

    public function update(User $user, City $city): bool
    {
        return $user->can('edit_cities');
    }

    public function delete(User $user, City $city): bool
    {
        return $user->can('delete_cities');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_cities');
    }

    public function forceDelete(User $user, City $city): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, City $city): bool
    {
        return $user->can('edit_cities');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('edit_cities');
    }
}
