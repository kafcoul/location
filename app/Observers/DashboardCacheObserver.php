<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class DashboardCacheObserver
{
    /**
     * Clés de cache du dashboard à invalider
     * quand des données sont créées/modifiées/supprimées.
     */
    private array $cacheKeys = [
        'dashboard:stats',
        'dashboard:reservation_chart',
        'dashboard:top_vehicles',
        'dashboard:new_users_chart',
    ];

    public function created($model): void
    {
        $this->flush();
    }

    public function updated($model): void
    {
        $this->flush();
    }

    public function deleted($model): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        foreach ($this->cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
