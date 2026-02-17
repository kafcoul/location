<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('view_users');
    }

    public function create(User $user): bool
    {
        return $user->can('create_users');
    }

    public function update(User $user, User $model): bool
    {
        if ($model->isSuperAdmin() && !$user->isSuperAdmin()) {
            return false;
        }

        return $user->can('edit_users');
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->id === $user->id) {
            return false;
        }

        if ($model->isSuperAdmin()) {
            return false;
        }

        return $user->can('delete_users');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_users');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can('edit_users');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('edit_users');
    }
}
