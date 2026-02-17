<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $city = City::create(['name' => 'Abidjan', 'slug' => 'abidjan']);

        Vehicle::create([
            'city_id' => $city->id,
            'name' => 'Test Car',
            'slug' => 'test-car',
            'brand' => 'Toyota',
            'price_per_day' => 25000,
            'deposit_amount' => 100000,
            'description' => 'Test',
            'is_available' => true,
        ]);
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml');
    }

    public function test_sitemap_contains_homepage(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString(url('/'), $response->getContent());
    }

    public function test_sitemap_contains_cities(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('/ville/abidjan', $response->getContent());
    }

    public function test_sitemap_contains_vehicles(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('/voiture/test-car', $response->getContent());
    }

    public function test_robots_txt_returns_text(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk()
            ->assertSee('User-agent: *')
            ->assertSee('Sitemap:');
    }

    public function test_robots_disallows_admin(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk()
            ->assertSee('Disallow: /admin');
    }

    public function test_homepage_has_og_tags(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('og:title', false)
            ->assertSee('og:description', false);
    }

    public function test_pwa_files_exist(): void
    {
        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('offline.html'));
    }
}
