<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Paris',   'slug' => 'paris'],
            ['name' => 'Abidjan', 'slug' => 'abidjan'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['slug' => $city['slug']], $city);
        }
    }
}
