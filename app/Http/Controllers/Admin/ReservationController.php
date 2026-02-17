<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $reservations = Reservation::with('vehicle.city')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(25);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation): View
    {
        $reservation->load('vehicle.city');

        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Reservation::STATUSES),
        ]);

        $reservation->update(['status' => $data['status']]);

        return back()->with('success', 'Statut mis à jour.');
    }
}
