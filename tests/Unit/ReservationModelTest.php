<?php

namespace Tests\Unit;

use App\Models\City;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationModelTest extends TestCase
{
    use RefreshDatabase;

    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();

        $city = City::create(['name' => 'Abidjan', 'slug' => 'abidjan']);

        $this->vehicle = Vehicle::create([
            'city_id' => $city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
        ]);
    }

    public function test_reservation_belongs_to_vehicle(): void
    {
        $reservation = Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '0700000000',
            'email' => 'jean@test.com',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(3),
            'total_days' => 2,
            'estimated_total' => 50000,
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(Vehicle::class, $reservation->vehicle);
        $this->assertEquals('Test Car', $reservation->vehicle->name);
    }

    public function test_reservation_is_pending(): void
    {
        $reservation = new Reservation(['status' => 'pending']);
        $this->assertTrue($reservation->isPending());
    }

    public function test_reservation_is_confirmed(): void
    {
        $reservation = new Reservation(['status' => 'confirmed']);
        $this->assertTrue($reservation->isConfirmed());
    }

    public function test_reservation_status_constants(): void
    {
        $this->assertEquals('pending', Reservation::STATUS_PENDING);
        $this->assertEquals('confirmed', Reservation::STATUS_CONFIRMED);
        $this->assertEquals('cancelled', Reservation::STATUS_CANCELLED);
    }

    public function test_reservation_casts_dates(): void
    {
        $reservation = Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '0700000000',
            'email' => 'jean@test.com',
            'start_date' => '2025-03-01',
            'end_date' => '2025-03-05',
            'total_days' => 4,
            'estimated_total' => 100000,
            'status' => 'pending',
        ]);

        $reservation->refresh();
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $reservation->start_date);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $reservation->end_date);
    }

    public function test_reservation_total_days_is_integer(): void
    {
        $reservation = Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '0700000000',
            'email' => 'jean@test.com',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(4),
            'total_days' => 3,
            'estimated_total' => 75000,
            'status' => 'pending',
        ]);

        $reservation->refresh();
        $this->assertIsInt($reservation->total_days);
    }
}
