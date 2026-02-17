<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReservationFlowTest extends TestCase
{
    use RefreshDatabase;

    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $city = City::create(['name' => 'Paris', 'slug' => 'paris']);

        $this->vehicle = Vehicle::create([
            'city_id'        => $city->id,
            'name'           => 'Test Car',
            'slug'           => 'test-car',
            'price_per_day'  => 100,
            'deposit_amount' => 500,
            'description'    => 'test',
            'is_available'   => true,
        ]);
    }

    public function test_homepage_loads(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_city_page_loads(): void
    {
        $this->get('/ville/paris')->assertOk()->assertSee('Paris');
    }

    public function test_vehicle_page_loads(): void
    {
        $this->get('/voiture/test-car')->assertOk()->assertSee('Test Car');
    }

    public function test_reservation_is_created(): void
    {
        $response = $this->post('/reservation', [
            'vehicle_id' => $this->vehicle->id,
            'full_name'  => 'Jean Dupont',
            'phone'      => '+33600000000',
            'email'      => 'jean@example.com',
            'start_date' => now()->addDay()->toDateString(),
            'end_date'   => now()->addDays(4)->toDateString(),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reservations', [
            'full_name'  => 'Jean Dupont',
            'status'     => 'pending',
            'total_days' => 3,
        ]);
    }

    public function test_validation_rejects_past_start_date(): void
    {
        $response = $this->post('/reservation', [
            'vehicle_id' => $this->vehicle->id,
            'full_name'  => 'Jean',
            'phone'      => '0600000000',
            'email'      => 'j@e.com',
            'start_date' => '2020-01-01',
            'end_date'   => '2020-01-05',
        ]);

        $response->assertSessionHasErrors('start_date');
    }

    public function test_validation_rejects_end_before_start(): void
    {
        $response = $this->post('/reservation', [
            'vehicle_id' => $this->vehicle->id,
            'full_name'  => 'Jean',
            'phone'      => '0600000000',
            'email'      => 'j@e.com',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date'   => now()->addDays(2)->toDateString(),
        ]);

        $response->assertSessionHasErrors('end_date');
    }
}
