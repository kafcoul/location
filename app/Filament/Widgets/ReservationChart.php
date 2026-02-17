<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReservationChart extends ChartWidget
{
    protected static ?string $heading = 'Revenus par mois';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        return Cache::remember('dashboard:reservation_chart', now()->addMinutes(10), function () {
            return $this->computeData();
        });
    }

    private function computeData(): array
    {
        $now = now();

        $monthly = Reservation::select(
                DB::raw("strftime('%Y-%m', created_at) as month"),
                DB::raw("SUM(CASE WHEN status = 'confirmed' THEN estimated_total ELSE 0 END) as revenue"),
                DB::raw('COUNT(*) as cnt')
            )
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $revenues = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $key = $date->format('Y-m');
            $labels[]   = $date->translatedFormat('M Y');
            $revenues[] = (int) ($monthly[$key]?->revenue ?? 0);
            $counts[]   = (int) ($monthly[$key]?->cnt ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenus (FCFA)',
                    'data' => $revenues,
                    'backgroundColor' => 'rgba(196, 163, 90, 0.6)',
                    'borderColor' => '#c4a35a',
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                    'order' => 2,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Réservations',
                    'data' => $counts,
                    'type' => 'line',
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderWidth' => 3,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#10b981',
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
                        'callback' => "function(value) { return value.toLocaleString('fr-FR') + ' F'; }",
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
