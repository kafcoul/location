<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verify2FA
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->two_factor_enabled) {
            return $next($request);
        }

        if ($request->session()->get('2fa_verified')) {
            return $next($request);
        }

        if ($request->is('admin/2fa-verify') || $request->is('admin/2fa-verify/*')) {
            return $next($request);
        }

        return redirect()->route('filament.admin.pages.two-factor-verify');
    }
}
