<?php

namespace Tests\Unit;

use App\Models\City;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleModelTest extends TestCase
{
    use RefreshDatabase;

    private City $city;

    protected function setUp(): void
    {
        parent::setUp();
        $this->city = City::create(['name' => 'Abidjan', 'slug' => 'abidjan']);
    }

    public function test_vehicle_belongs_to_city(): void
    {
        $vehicle = Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
        ]);

        $this->assertInstanceOf(City::class, $vehicle->city);
        $this->assertEquals('Abidjan', $vehicle->city->name);
    }

    public function test_vehicle_has_many_reservations(): void
    {
        $vehicle = Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
        ]);

        Reservation::create([
            'vehicle_id' => $vehicle->id,
            'full_name' => 'Jean',
            'phone' => '0700000000',
            'email' => 'jean@test.com',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(3),
            'total_days' => 2,
            'estimated_total' => 50000,
            'status' => 'pending',
        ]);

        $this->assertCount(1, $vehicle->reservations);
    }

    public function test_vehicle_casts_gallery_to_array(): void
    {
        $vehicle = Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
            'gallery' => ['img1.jpg', 'img2.jpg'],
        ]);

        $vehicle->refresh();
        $this->assertIsArray($vehicle->gallery);
        $this->assertCount(2, $vehicle->gallery);
    }

    public function test_vehicle_uses_slug_as_route_key(): void
    {
        $vehicle = Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
        ]);

        $this->assertEquals('slug', $vehicle->getRouteKeyName());
    }

    public function test_scope_available_filters_correctly(): void
    {
        Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Available Car',
            'slug' => 'available-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Available',
            'is_available' => true,
        ]);

        Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Unavailable Car',
            'slug' => 'unavailable-car',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Unavailable',
            'is_available' => false,
        ]);

        $available = Vehicle::available()->get();
        $this->assertCount(1, $available);
        $this->assertEquals('Available Car', $available->first()->name);
    }

    public function test_city_has_many_vehicles(): void
    {
        Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Car 1',
            'slug' => 'car-1',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Car 1',
            'is_available' => true,
        ]);

        Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Car 2',
            'slug' => 'car-2',
            'price_per_day' => 35000,
            'deposit_amount' => 150000,
            'description' => 'Car 2',
            'is_available' => true,
        ]);

        $this->assertCount(2, $this->city->vehicles);
    }

    public function test_city_uses_slug_as_route_key(): void
    {
        $this->assertEquals('slug', $this->city->getRouteKeyName());
    }
}
