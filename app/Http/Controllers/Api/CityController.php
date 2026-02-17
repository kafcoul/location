<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    /**
     * GET /api/cities
     */
    public function index()
    {
        $cities = City::withCount('vehicles')->get();

        return CityResource::collection($cities);
    }

    /**
     * GET /api/cities/{slug}
     */
    public function show(string $slug)
    {
        $city = City::where('slug', $slug)
            ->with(['vehicles' => fn ($q) => $q->where('is_available', true)])
            ->firstOrFail();

        return new CityResource($city);
    }
}
