<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // Forcer HTTPS en production
        if (env('FORCE_HTTPS', false)) {
            $middleware->trustProxies(headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO);
        }

        // Mode maintenance : exclure /admin/* pour que les admins gardent l'accès
        $middleware->preventRequestsDuringMaintenance(
            except: ['admin/*', 'admin', 'livewire/*', 'filament/*', 'up']
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // ── 404 — Page non trouvée ───────────────────────
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ressource non trouvée.',
                    'error' => 'not_found',
                ], 404);
            }

            return response()->view('errors.404', [
                'message' => 'La page que vous cherchez n\'existe pas.',
            ], 404);
        });

        // ── 419 — Session expirée / CSRF ─────────────────
        $exceptions->renderable(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expirée, veuillez recharger la page.',
                    'error' => 'token_mismatch',
                ], 419);
            }

            return response()->view('errors.419', [
                'message' => 'Votre session a expiré. Veuillez rafraîchir la page.',
            ], 419);
        });

        // ── 429 — Trop de requêtes ───────────────────────
        $exceptions->renderable(function (TooManyRequestsHttpException $e, Request $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Trop de requêtes. Réessayez dans ' . $retryAfter . ' secondes.',
                    'error' => 'too_many_requests',
                    'retry_after' => $retryAfter,
                ], 429);
            }

            return response()->view('errors.429', [
                'message' => 'Trop de requêtes. Veuillez patienter un moment.',
                'retryAfter' => $retryAfter,
            ], 429);
        });

        // ── 500 — Erreur serveur (fallback global) ───────
        $exceptions->renderable(function (Throwable $e, Request $request) {
            // Ne pas intercepter les exceptions HTTP déjà gérées
            if ($e instanceof HttpExceptionInterface) {
                $code = $e->getStatusCode();
                if (in_array($code, [401, 403, 404, 419, 429, 503])) {
                    return null; // Laisser Laravel gérer
                }
            }

            // Uniquement en production pour les erreurs critiques
            if (app()->isProduction() && !$e instanceof HttpExceptionInterface) {
                Log::channel('stack')->critical('Erreur serveur non gérée', [
                    'exception' => get_class($e),
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'url'       => $request->fullUrl(),
                    'user_id'   => $request->user()?->id,
                    'ip'        => $request->ip(),
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Une erreur interne est survenue. Notre équipe a été notifiée.',
                        'error' => 'server_error',
                    ], 500);
                }

                return response()->view('errors.500', [
                    'message' => 'Une erreur interne est survenue.',
                ], 500);
            }

            return null;
        });

        // ── Log des erreurs non-authentification ─────────
        $exceptions->reportable(function (Throwable $e) {
            // En production, on log dans le channel spécifique si c'est critique
            if (app()->isProduction() && !$e instanceof AuthenticationException) {
                Log::channel('daily')->error($e->getMessage(), [
                    'exception' => get_class($e),
                    'trace'     => $e->getTraceAsString(),
                ]);
            }
        })->stop();

    })->create();
