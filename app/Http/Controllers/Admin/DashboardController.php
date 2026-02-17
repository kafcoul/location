<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'pending'   => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
            'total'     => Reservation::count(),
        ];

        $recent = Reservation::with('vehicle.city')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
