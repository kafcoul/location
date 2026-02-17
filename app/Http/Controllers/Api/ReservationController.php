<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * GET /api/reservations (auth required)
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with('vehicle.city')
            ->where('email', $request->user()->email)
            ->latest()
            ->paginate(10);

        return ReservationResource::collection($reservations);
    }

    /**
     * POST /api/reservations
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_slug'       => 'required|exists:vehicles,slug',
            'full_name'          => 'required|string|max:255',
            'phone'              => 'required|string|max:30',
            'email'              => 'required|email|max:255',
            'license_seniority'  => 'nullable|string|max:50',
            'birth_day'          => 'nullable|integer|min:1|max:31',
            'birth_month'        => 'nullable|integer|min:1|max:12',
            'birth_year'         => 'nullable|integer|min:1940|max:2010',
            'start_date'         => 'required|date|after_or_equal:today',
            'end_date'           => 'required|date|after:start_date',
            'notes'              => 'nullable|string|max:1000',
        ]);

        $vehicle = Vehicle::where('slug', $data['vehicle_slug'])->firstOrFail();

        $start = Carbon::parse($data['start_date']);
        $end   = Carbon::parse($data['end_date']);
        $days  = max(1, $start->diffInDays($end));

        $reservation = Reservation::create([
            'vehicle_id'        => $vehicle->id,
            'full_name'         => $data['full_name'],
            'phone'             => $data['phone'],
            'email'             => $data['email'],
            'license_seniority' => $data['license_seniority'] ?? null,
            'birth_day'         => $data['birth_day'] ?? null,
            'birth_month'       => $data['birth_month'] ?? null,
            'birth_year'        => $data['birth_year'] ?? null,
            'start_date'        => $start,
            'end_date'          => $end,
            'total_days'        => $days,
            'estimated_total'   => $days * $vehicle->price_per_day,
            'status'            => Reservation::STATUS_PENDING,
            'notes'             => $data['notes'] ?? null,
        ]);

        return (new ReservationResource($reservation->load('vehicle')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * GET /api/reservations/{id} (auth required)
     */
    public function show(Request $request, Reservation $reservation)
    {
        if ($reservation->email !== $request->user()->email) {
            abort(403, 'Accès non autorisé.');
        }

        return new ReservationResource($reservation->load('vehicle'));
    }

    /**
     * PATCH /api/reservations/{id}/cancel (auth required)
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->email !== $request->user()->email) {
            abort(403, 'Accès non autorisé.');
        }

        if (! $reservation->isPending()) {
            return response()->json(['message' => 'Seules les réservations en attente peuvent être annulées.'], 422);
        }

        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);

        return new ReservationResource($reservation->load('vehicle'));
    }
}
