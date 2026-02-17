<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NewUsersChart extends ChartWidget
{
    protected static ?string $heading = 'Nouveaux utilisateurs';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('dashboard:new_users_chart', now()->addMinutes(10), function () {
            return $this->computeData();
        });
    }

    /**
     * 2 requêtes au lieu de 12+ : 1 groupée + 1 count de base.
     */
    private function computeData(): array
    {
        $now = now();
        $startDate = $now->copy()->subMonths(11)->startOfMonth();

        // 1 requête : nouveaux users par mois
        $monthly = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('month')
            ->pluck('total', 'month');

        // 1 requête : users avant la période (base cumulative)
        $baseCumulative = User::where('created_at', '<', $startDate)->count();

        $labels     = [];
        $newUsers   = [];
        $cumulative = [];
        $running    = $baseCumulative;

        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $key  = $date->format('Y-m');
            $labels[] = $date->translatedFormat('M Y');

            $count       = (int) ($monthly[$key] ?? 0);
            $newUsers[]  = $count;
            $running    += $count;
            $cumulative[] = $running;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nouveaux inscrits',
                    'data' => $newUsers,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.6)',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                    'order' => 2,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total cumulé',
                    'data' => $cumulative,
                    'type' => 'line',
                    'borderColor' => '#c4a35a',
                    'backgroundColor' => 'rgba(196, 163, 90, 0.1)',
                    'borderWidth' => 3,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#c4a35a',
                    'fill' => true,
                    'tension' => 0.4,
                    'order' => 1,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'position' => 'left',
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                    'grid' => [
                        'display' => true,
                    ],
                ],
                'y1' => [
                    'position' => 'right',
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
