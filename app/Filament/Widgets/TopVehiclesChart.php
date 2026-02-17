<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopVehiclesChart extends ChartWidget
{
    protected static ?string $heading = 'Top véhicules réservés';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('dashboard:top_vehicles', now()->addMinutes(10), function () {
            return $this->computeData();
        });
    }

    /**
     * 1 seule requête avec JOIN au lieu de N+1
     */
    private function computeData(): array
    {
        $topVehicles = Reservation::select(
                'reservations.vehicle_id',
                'vehicles.name',
                DB::raw('COUNT(*) as total')
            )
            ->join('vehicles', 'vehicles.id', '=', 'reservations.vehicle_id')
            ->groupBy('reservations.vehicle_id', 'vehicles.name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $labels = $topVehicles->pluck('name')->map(fn ($n) => $n ?? 'Inconnu')->toArray();
        $data   = $topVehicles->pluck('total')->toArray();

        $colors = [
            'rgba(196, 163, 90, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(139, 92, 246, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(20, 184, 166, 0.8)',
            'rgba(249, 115, 22, 0.8)',
        ];

        $borderColors = [
            '#c4a35a', '#10b981', '#3b82f6', '#f59e0b',
            '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Réservations',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderColor' => array_slice($borderColors, 0, count($data)),
                    'borderWidth' => 2,
                    'borderRadius' => 6,
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
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
