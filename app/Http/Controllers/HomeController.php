<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Vehicle;
use Illuminate\View\View;

class HomeController extends Controller
{
        public function index(): View
    {
        $cities = City::withCount('availableVehicles')->get();

        return view('pages.home', compact('cities'));
    }

    public function showCity(City $slug): View
    {
        $city     = $slug;
        $vehicles = $city->vehicles()
            ->available()
            ->select(['id', 'city_id', 'name', 'slug', 'brand', 'image', 'price_per_day', 'gearbox', 'fuel', 'seats', 'is_available'])
            ->get();

        return view('pages.city', compact('city', 'vehicles'));
    }

    public function showVehicle(Vehicle $slug): View
    {
        $vehicle = $slug->load('city:id,name,slug');

        return view('pages.vehicle', compact('vehicle'));
    }

    public function reservationForm(Vehicle $slug): View
    {
        $vehicle  = $slug->load('city:id,name,slug');
        $vehicles = Vehicle::where('is_available', true)
            ->select(['id', 'name', 'price_per_day'])
            ->orderBy('name')
            ->get();

        return view('pages.reservation', compact('vehicle', 'vehicles'));
    }

        public function faq(): View
    {
        return view('pages.faq');
    }

        public function accompagnement(): View
    {
        return view('pages.accompagnement');
    }

        public function mentionsLegales(): View
    {
        return view('pages.mentions-legales');
    }
}
