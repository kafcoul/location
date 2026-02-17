<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * GET /api/vehicles
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('city')->available();

        if ($request->filled('city')) {
            $query->whereHas('city', fn ($q) => $q->where('slug', $request->city));
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        if ($request->filled('seats')) {
            $query->where('seats', '>=', $request->seats);
        }

        if ($request->filled('gearbox')) {
            $query->where('gearbox', $request->gearbox);
        }

        $sort = $request->input('sort', 'created_at');
        $dir  = $request->input('dir', 'desc');
        $query->orderBy($sort, $dir);

        $vehicles = $query->paginate($request->input('per_page', 15));

        return VehicleResource::collection($vehicles);
    }

    /**
     * GET /api/vehicles/{slug}
     */
    public function show(string $slug)
    {
        $vehicle = Vehicle::with('city')->where('slug', $slug)->firstOrFail();

        return new VehicleResource($vehicle);
    }
}
