<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        activity()
            ->causedBy($request->user())
            ->withProperties([
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('Connexion');

        $redirect = $request->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Support'])
            ? '/admin'
            : route('home', absolute: false);

        return redirect()->intended($redirect);
    }

    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()) {
            activity()
                ->causedBy($request->user())
                ->withProperties(['ip' => $request->ip()])
                ->log('Déconnexion');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
