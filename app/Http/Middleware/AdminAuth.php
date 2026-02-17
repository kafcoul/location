<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Support'])) {
            abort(403, 'Accès réservé à l\'administration.');
        }

        return $next($request);
    }
}
