<?php

namespace App\Providers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Observers\DashboardCacheObserver;
use App\Observers\AdminNotificationObserver;
use App\Observers\UserNotificationObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ── Sécurité Eloquent ──────────────────────────────
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

        // ── Invalidation cache dashboard ──────────────────
        Reservation::observe(DashboardCacheObserver::class);
        User::observe(DashboardCacheObserver::class);
        Vehicle::observe(DashboardCacheObserver::class);

        // ── Notifications admin temps réel ─────────────────
        Reservation::observe(AdminNotificationObserver::class);
        User::observe(UserNotificationObserver::class);

        // ── Super Admin bypass ─────────────────────────────
        Gate::before(function ($user, $ability) {
            return $user->isSuperAdmin() ? true : null;
        });

        Gate::policy(\Spatie\Permission\Models\Role::class, \App\Policies\RolePolicy::class);
    }
}
