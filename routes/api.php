<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes — CKF Motors
|--------------------------------------------------------------------------
| Prefix: /api
| Auth: Laravel Sanctum (Bearer token)
|--------------------------------------------------------------------------
*/

// ── Public ──────────────────────────────────────
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::get('/vehicles',       [VehicleController::class, 'index']);
Route::get('/vehicles/{slug}', [VehicleController::class, 'show']);

Route::get('/cities',        [CityController::class, 'index']);
Route::get('/cities/{slug}', [CityController::class, 'show']);

Route::post('/reservations', [ReservationController::class, 'store'])
    ->middleware('throttle:10,1');

// ── Authentifié (Sanctum) ───────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',     [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/reservations',              [ReservationController::class, 'index']);
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);
    Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel']);
});
