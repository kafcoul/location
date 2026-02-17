<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ville/{slug}', [HomeController::class, 'showCity'])->name('city.show');
Route::get('/voiture/{slug}', [HomeController::class, 'showVehicle'])->name('vehicle.show');
Route::get('/voiture/{slug}/reservation', [HomeController::class, 'reservationForm'])->name('reservation.form');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/accompagnement', [HomeController::class, 'accompagnement'])->name('accompagnement');

// SEO
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

Route::post('/reservation', [ReservationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('reservation.store');

Route::get('/reservation/{id}/confirmation', [ReservationController::class, 'confirmation'])
    ->name('reservation.confirmation');

Route::get('/dashboard', function () {
    if (auth()->user()?->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Support'])) {
        return redirect('/admin');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
