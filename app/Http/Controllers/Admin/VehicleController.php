<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with('city')->latest()->paginate(20);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        $cities = City::all();

        return view('admin.vehicles.create', compact('cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'city_id'               => 'required|exists:cities,id',
            'brand'                 => 'required|string|max:100',
            'model'                 => 'required|string|max:100',
            'name'                  => 'required|string|max:255',
            'price_per_day'         => 'required|integer|min:1',
            'deposit_amount'        => 'required|integer|min:0',
            'km_price'              => 'nullable|numeric|min:0',
            'weekly_price'          => 'nullable|integer|min:0',
            'monthly_classic_price' => 'nullable|integer|min:0',
            'monthly_premium_price' => 'nullable|integer|min:0',
            'year'                  => 'nullable|string|max:4',
            'gearbox'               => 'nullable|string|max:50',
            'power'                 => 'nullable|string|max:50',
            'seats'                 => 'nullable|integer|min:1|max:9',
            'fuel'                  => 'nullable|string|max:50',
            'carplay'               => 'boolean',
            'description'           => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available'          => 'boolean',
        ]);

        $data['slug']         = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_available'] = $request->boolean('is_available', true);
        $data['carplay']      = $request->boolean('carplay', false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule ajouté.');
    }

    public function edit(Vehicle $vehicle): View
    {
        $cities = City::all();

        return view('admin.vehicles.edit', compact('vehicle', 'cities'));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validate([
            'city_id'               => 'required|exists:cities,id',
            'brand'                 => 'required|string|max:100',
            'model'                 => 'required|string|max:100',
            'name'                  => 'required|string|max:255',
            'price_per_day'         => 'required|integer|min:1',
            'deposit_amount'        => 'required|integer|min:0',
            'km_price'              => 'nullable|numeric|min:0',
            'weekly_price'          => 'nullable|integer|min:0',
            'monthly_classic_price' => 'nullable|integer|min:0',
            'monthly_premium_price' => 'nullable|integer|min:0',
            'year'                  => 'nullable|string|max:4',
            'gearbox'               => 'nullable|string|max:50',
            'power'                 => 'nullable|string|max:50',
            'seats'                 => 'nullable|integer|min:1|max:9',
            'fuel'                  => 'nullable|string|max:50',
            'carplay'               => 'boolean',
            'description'           => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available'          => 'boolean',
        ]);

        $data['is_available'] = $request->boolean('is_available', true);
        $data['carplay']      = $request->boolean('carplay', false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule mis à jour.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule supprimé.');
    }
}
