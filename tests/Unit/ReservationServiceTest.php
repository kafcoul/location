<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use App\Services\ReservationService;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    private ReservationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ReservationService();
    }

    public function test_calculate_days_normal(): void
    {
        $days = $this->service->calculateDays('2026-03-01', '2026-03-05');
        $this->assertEquals(4, $days);
    }

    public function test_calculate_days_same_day_returns_min_one(): void
    {
        $days = $this->service->calculateDays('2026-03-01', '2026-03-01');
        $this->assertEquals(1, $days);
    }

    public function test_estimate_total(): void
    {
        $vehicle = new Vehicle(['price_per_day' => 350]);
        $total   = $this->service->estimateTotal(3, $vehicle);
        $this->assertEquals(1050, $total);
    }
}
