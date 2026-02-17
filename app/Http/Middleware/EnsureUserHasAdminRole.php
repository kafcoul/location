<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('home');
        }

        if (!$request->user()->canAccessPanel(filament()->getCurrentPanel() ?? filament()->getDefaultPanel())) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
