<?php

namespace Tests\Feature\Api;

use App\Models\City;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationApiTest extends TestCase
{
    use RefreshDatabase;

    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();

        $city = City::create(['name' => 'Abidjan', 'slug' => 'abidjan']);

        $this->vehicle = Vehicle::create([
            'city_id' => $city->id,
            'name' => 'Toyota Corolla',
            'slug' => 'toyota-corolla',
            'brand' => 'Toyota',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Berline fiable',
            'is_available' => true,
        ]);
    }

    public function test_create_reservation(): void
    {
        $response = $this->postJson('/api/reservations', [
            'vehicle_slug' => $this->vehicle->slug,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'full_name', 'phone', 'email', 'start_date', 'end_date', 'total_days', 'estimated_total', 'status'],
            ]);

        $this->assertDatabaseHas('reservations', [
            'full_name' => 'Jean Kouassi',
            'vehicle_id' => $this->vehicle->id,
            'status' => 'pending',
        ]);
    }

    public function test_create_reservation_validates_required_fields(): void
    {
        $response = $this->postJson('/api/reservations', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['vehicle_slug', 'full_name', 'phone', 'email', 'start_date', 'end_date']);
    }

    public function test_create_reservation_validates_dates(): void
    {
        $response = $this->postJson('/api/reservations', [
            'vehicle_slug' => $this->vehicle->slug,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['start_date']);
    }

    public function test_end_date_must_be_after_start_date(): void
    {
        $response = $this->postJson('/api/reservations', [
            'vehicle_slug' => $this->vehicle->slug,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    public function test_authenticated_user_can_list_reservations(): void
    {
        $user = User::factory()->create(['email' => 'jean@example.com']);

        Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
            'total_days' => 3,
            'estimated_total' => 75000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/reservations');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'full_name', 'status'],
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_list_reservations(): void
    {
        $response = $this->getJson('/api/reservations');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_cancel_pending_reservation(): void
    {
        $user = User::factory()->create(['email' => 'jean@example.com']);

        $reservation = Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
            'total_days' => 3,
            'estimated_total' => 75000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->patchJson("/api/reservations/{$reservation->id}/cancel");

        $response->assertOk()
            ->assertJsonPath('data.status', 'cancelled');
    }

    public function test_cannot_cancel_confirmed_reservation(): void
    {
        $user = User::factory()->create(['email' => 'jean@example.com']);

        $reservation = Reservation::create([
            'vehicle_id' => $this->vehicle->id,
            'full_name' => 'Jean Kouassi',
            'phone' => '+225 07 00 00 00',
            'email' => 'jean@example.com',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
            'total_days' => 3,
            'estimated_total' => 75000,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->patchJson("/api/reservations/{$reservation->id}/cancel");

        $response->assertStatus(422);
    }
}
