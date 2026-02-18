<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $data = Cache::remember('dashboard:stats', now()->addMinutes(5), function () {
            return $this->computeStats();
        });

        return [
            $this->buildUsersStat($data),
            $this->buildRevenueStat($data),
            $this->buildTodayStat($data),
            $this->buildGrowthStat($data),
        ];
    }

    private function computeStats(): array
    {
        $now = now();

        $usersByMonth = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        $totalUsers = User::count();

        $confirmedByMonth = Reservation::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(estimated_total) as revenue'),
                DB::raw('COUNT(*) as cnt')
            )
            ->where('status', 'confirmed')
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $todayStats = Reservation::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending")
            )
            ->whereDate('created_at', '>=', today()->subDay())
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $dailyTrend = Reservation::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw('COUNT(*) as total')
            )
            ->whereDate('created_at', '>=', today()->subDays(13))
            ->groupBy('day')
            ->pluck('total', 'day');

        $totalRevenue = Reservation::where('status', 'confirmed')->sum('estimated_total');

        $userTrend = [];
        $revenueTrend = [];
        $growthTrend = [];
        $currentKey = $now->format('Y-m');
        $lastKey = $now->copy()->subMonth()->format('Y-m');

        for ($i = 11; $i >= 0; $i--) {
            $key = $now->copy()->subMonths($i)->format('Y-m');
            $userTrend[]    = (int) ($usersByMonth[$key] ?? 0);
            $revenueTrend[] = (int) ($confirmedByMonth[$key]?->revenue ?? 0);
            $growthTrend[]  = (int) ($confirmedByMonth[$key]?->cnt ?? 0);
        }

        $dailyTrendData = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = today()->subDays($i)->format('Y-m-d');
            $dailyTrendData[] = (int) ($dailyTrend[$day] ?? 0);
        }

        $todayKey = today()->format('Y-m-d');
        $yesterdayKey = today()->subDay()->format('Y-m-d');

        return [
            'totalUsers'          => $totalUsers,
            'usersThisMonth'      => (int) ($usersByMonth[$currentKey] ?? 0),
            'usersLastMonth'      => (int) ($usersByMonth[$lastKey] ?? 0),
            'userTrend'           => $userTrend,
            'revenueThisMonth'    => (int) ($confirmedByMonth[$currentKey]?->revenue ?? 0),
            'revenueLastMonth'    => (int) ($confirmedByMonth[$lastKey]?->revenue ?? 0),
            'revenueTrend'        => $revenueTrend,
            'todayCount'          => (int) ($todayStats[$todayKey]?->total ?? 0),
            'todayPending'        => (int) ($todayStats[$todayKey]?->pending ?? 0),
            'yesterdayCount'      => (int) ($todayStats[$yesterdayKey]?->total ?? 0),
            'dailyTrend'          => $dailyTrendData,
            'confirmedThisMonth'  => (int) ($confirmedByMonth[$currentKey]?->cnt ?? 0),
            'confirmedLastMonth'  => (int) ($confirmedByMonth[$lastKey]?->cnt ?? 0),
            'totalRevenue'        => (int) $totalRevenue,
            'growthTrend'         => $growthTrend,
        ];
    }

    private function buildUsersStat(array $d): Stat
    {
        $trend = $d['usersLastMonth'] > 0
            ? round(($d['usersThisMonth'] - $d['usersLastMonth']) / $d['usersLastMonth'] * 100, 1)
            : ($d['usersThisMonth'] > 0 ? 100 : 0);

        $icon = $trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        return Stat::make('Total utilisateurs', number_format($d['totalUsers'], 0, ',', '.'))
            ->description(($trend >= 0 ? '+' : '') . $trend . '% vs mois dernier')
            ->descriptionIcon($icon)
            ->color($trend >= 0 ? 'success' : 'danger')
            ->chart($d['userTrend']);
    }

    private function buildRevenueStat(array $d): Stat
    {
        $trend = $d['revenueLastMonth'] > 0
            ? round(($d['revenueThisMonth'] - $d['revenueLastMonth']) / $d['revenueLastMonth'] * 100, 1)
            : ($d['revenueThisMonth'] > 0 ? 100 : 0);

        $icon = $trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        return Stat::make('Revenus mensuels', number_format($d['revenueThisMonth'], 0, ',', '.') . ' FCFA')
            ->description(($trend >= 0 ? '+' : '') . $trend . '% vs mois dernier')
            ->descriptionIcon($icon)
            ->color($trend >= 0 ? 'success' : 'danger')
            ->chart($d['revenueTrend']);
    }

    private function buildTodayStat(array $d): Stat
    {
        $diff = $d['todayCount'] - $d['yesterdayCount'];
        $description = $diff > 0
            ? '+' . $diff . ' vs hier'
            : ($diff < 0 ? $diff . ' vs hier' : 'Identique à hier');

        return Stat::make("Transactions aujourd'hui", $d['todayCount'])
            ->description($d['todayPending'] > 0 ? $d['todayPending'] . ' en attente · ' . $description : $description)
            ->descriptionIcon('heroicon-m-clock')
            ->color('warning')
            ->chart($d['dailyTrend']);
    }

    private function buildGrowthStat(array $d): Stat
    {
        $growth = $d['confirmedLastMonth'] > 0
            ? round(($d['confirmedThisMonth'] - $d['confirmedLastMonth']) / $d['confirmedLastMonth'] * 100, 1)
            : ($d['confirmedThisMonth'] > 0 ? 100 : 0);

        $icon = $growth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';

        return Stat::make('Croissance', ($growth >= 0 ? '+' : '') . $growth . '%')
            ->description(number_format($d['totalRevenue'], 0, ',', '.') . ' FCFA au total')
            ->descriptionIcon($icon)
            ->color($growth >= 0 ? 'success' : 'danger')
            ->chart($d['growthTrend']);
    }
}
