<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Notification;

class UserNotificationObserver
{
    /**
     * Nouvel utilisateur inscrit → notification admins.
     */
    public function created(User $user): void
    {
        $admins = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Super Admin', 'Admin']);
        })->where('id', '!=', $user->id)->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('Nouvel utilisateur inscrit')
                ->body($user->name . ' (' . $user->email . ')')
                ->icon('heroicon-o-user-plus')
                ->iconColor('info')
                ->sendToDatabase($admin);
        }
    }
}
