<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
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
            'name' => 'Mercedes Classe C',
            'slug' => 'mercedes-classe-c',
            'brand' => 'Mercedes',
            'model' => 'Classe C',
            'price_per_day' => 60000,
            'deposit_amount' => 250000,
            'description' => 'Berline premium',
            'is_available' => true,
        ]);
    }

    public function test_homepage_loads_successfully(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_homepage_displays_brand(): void
    {
        $this->get('/')->assertSee('CKF');
    }

    public function test_city_page_loads(): void
    {
        $this->get('/ville/abidjan')->assertOk()->assertSee('Abidjan');
    }

    public function test_city_page_shows_vehicles(): void
    {
        $this->get('/ville/abidjan')->assertOk()->assertSee('Mercedes Classe C');
    }

    public function test_city_page_returns_404_for_invalid_slug(): void
    {
        $this->get('/ville/nonexistent')->assertStatus(404);
    }

    public function test_vehicle_page_loads(): void
    {
        $this->get('/voiture/mercedes-classe-c')->assertOk()->assertSee('Mercedes');
    }

    public function test_vehicle_page_shows_price(): void
    {
        $this->get('/voiture/mercedes-classe-c')->assertOk()->assertSee('60');
    }

    public function test_vehicle_page_returns_404_for_invalid_slug(): void
    {
        $this->get('/voiture/nonexistent')->assertStatus(404);
    }

    public function test_faq_page_loads(): void
    {
        $this->get('/faq')->assertOk();
    }

    public function test_accompagnement_page_loads(): void
    {
        $this->get('/accompagnement')->assertOk();
    }

    public function test_reservation_form_loads(): void
    {
        $this->get('/voiture/mercedes-classe-c/reservation')->assertOk();
    }

    public function test_reservation_form_returns_404_for_invalid_vehicle(): void
    {
        $this->get('/voiture/nonexistent/reservation')->assertStatus(404);
    }

    public function test_mentions_legales_page_loads(): void
    {
        $this->get('/mentions-legales')->assertOk()->assertSee('Mentions');
    }
}
