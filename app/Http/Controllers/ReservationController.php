<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Vehicle;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $service,
    ) {}

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $vehicle = Vehicle::select(['id', 'price_per_day', 'is_available'])->findOrFail($request->vehicle_id);

        if (! $vehicle->is_available) {
            return back()->withErrors(['vehicle_id' => 'Ce véhicule est momentanément indisponible.']);
        }

        $data = $request->validated();

        if (empty($data['full_name']) && !empty($data['first_name'])) {
            $data['full_name'] = trim($data['first_name'] . ' ' . ($data['last_name'] ?? ''));
        }

        $reservation = $this->service->create($data, $vehicle);

        return redirect()
            ->route('reservation.confirmation', $reservation)
            ->with('success', 'Votre demande a été enregistrée.');
    }

    public function confirmation($id)
    {
        $reservation = \App\Models\Reservation::with('vehicle:id,name,slug,image,price_per_day,city_id', 'vehicle.city:id,name,slug')->findOrFail($id);

        return view('pages.confirmation', compact('reservation'));
    }
}
