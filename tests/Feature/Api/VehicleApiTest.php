<?php

namespace Tests\Feature\Api;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleApiTest extends TestCase
{
    use RefreshDatabase;

    private City $city;
    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();

        $this->city = City::create(['name' => 'Abidjan', 'slug' => 'abidjan']);

        $this->vehicle = Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'Toyota Land Cruiser',
            'slug' => 'toyota-land-cruiser',
            'brand' => 'Toyota',
            'model' => 'Land Cruiser',
            'year' => 2024,
            'gearbox' => 'Automatique',
            'seats' => 5,
            'fuel' => 'Diesel',
            'price_per_day' => 50000,
            'deposit_amount' => 200000,
            'description' => 'SUV premium',
            'is_available' => true,
        ]);
    }

    public function test_list_vehicles(): void
    {
        $response = $this->getJson('/api/vehicles');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'brand', 'slug', 'pricing'],
                ],
            ]);
    }

    public function test_show_vehicle_by_slug(): void
    {
        $response = $this->getJson('/api/vehicles/toyota-land-cruiser');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Toyota Land Cruiser')
            ->assertJsonPath('data.brand', 'Toyota');
    }

    public function test_show_vehicle_not_found(): void
    {
        $response = $this->getJson('/api/vehicles/nonexistent-slug');

        $response->assertStatus(404);
    }

    public function test_filter_vehicles_by_city(): void
    {
        $city2 = City::create(['name' => 'Bouaké', 'slug' => 'bouake']);
        Vehicle::create([
            'city_id' => $city2->id,
            'name' => 'Honda Civic',
            'slug' => 'honda-civic',
            'brand' => 'Honda',
            'price_per_day' => 30000,
            'deposit_amount' => 100000,
            'description' => 'Berline',
            'is_available' => true,
        ]);

        $response = $this->getJson('/api/vehicles?city=abidjan');

        $response->assertOk();
        $data = $response->json('data');
        foreach ($data as $v) {
            $this->assertEquals('Abidjan', $v['city']['name']);
        }
    }

    public function test_filter_vehicles_by_brand(): void
    {
        Vehicle::create([
            'city_id' => $this->city->id,
            'name' => 'BMW X5',
            'slug' => 'bmw-x5',
            'brand' => 'BMW',
            'price_per_day' => 80000,
            'deposit_amount' => 300000,
            'description' => 'SUV luxe',
            'is_available' => true,
        ]);

        $response = $this->getJson('/api/vehicles?brand=Toyota');

        $response->assertOk();
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Toyota', $data[0]['brand']);
    }

    public function test_filter_vehicles_by_price_range(): void
    {
        $response = $this->getJson('/api/vehicles?min_price=40000&max_price=60000');

        $response->assertOk();
        $data = $response->json('data');
        foreach ($data as $v) {
            $this->assertGreaterThanOrEqual(40000, $v['pricing']['price_per_day']);
            $this->assertLessThanOrEqual(60000, $v['pricing']['price_per_day']);
        }
    }

    public function test_filter_vehicles_by_seats(): void
    {
        $response = $this->getJson('/api/vehicles?seats=5');

        $response->assertOk();
        $data = $response->json('data');
        foreach ($data as $v) {
            $this->assertEquals(5, $v['seats']);
        }
    }

    public function test_list_cities(): void
    {
        $response = $this->getJson('/api/cities');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'vehicles_count'],
                ],
            ]);
    }

    public function test_show_city_by_slug(): void
    {
        $response = $this->getJson('/api/cities/abidjan');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Abidjan');
    }

    public function test_show_city_not_found(): void
    {
        $response = $this->getJson('/api/cities/nonexistent');

        $response->assertStatus(404);
    }
}
