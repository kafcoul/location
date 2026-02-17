# Architecture Laravel — CKF Motors (V1)

## Objectif
Décrire une architecture Laravel propre et maintenable, adaptée à la prod : séparation des responsabilités, validation centralisée, service layer, routes claires.

---

## 1) Structure recommandée

```txt
app/
 ├── Models/
 ├── Http/
 │    ├── Controllers/
 │    ├── Requests/
 │    ├── Middleware/
 ├── Services/
 ├── Repositories/

resources/
 ├── views/
 │    ├── layouts/
 │    ├── pages/
 │    ├── components/
 │    ├── admin/

routes/
 ├── web.php

database/
 ├── migrations/
 ├── seeders/
```

---

## 2) Modèles & relations

### `City`
- Fillable : `name`, `slug`
- Relation : `City hasMany Vehicle`

### `Vehicle`
- Fillable :
  - `city_id`, `name`, `slug`, `price_per_day`, `deposit_amount`, `description`, `image`, `is_available`
- Relations :
  - `Vehicle belongsTo City`
  - `Vehicle hasMany Reservation`

### `Reservation`
- Fillable :
  - `vehicle_id`, `full_name`, `phone`, `email`, `start_date`, `end_date`, `total_days`, `estimated_total`, `status`, `notes`
- Relation : `Reservation belongsTo Vehicle`

---

## 3) Controllers (responsabilités)

### `HomeController`
- `index()` : homepage (hero + villes)
- `showCity($slug)` : liste véhicules d’une ville
- `showVehicle($slug)` : fiche véhicule + CTA réserver

### `ReservationController`
- `store(StoreReservationRequest $request)` :
  - valide l’entrée
  - retrouve le véhicule
  - appelle `ReservationService`
  - retourne page/JSON de confirmation

### `AdminController`
- `dashboard()` : KPIs simples (réservations pending, confirmed)
- Vehicles : CRUD
- Reservations : listing + update status

> Recommandation : séparer en `Admin/VehicleController` et `Admin/ReservationController` si le back-office grossit.

---

## 4) Requests (validation)

### `StoreReservationRequest`
Règles minimales :
```php
public function rules()
{
    return [
        'full_name' => 'required|string',
        'phone' => 'required',
        'email' => 'required|email',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
    ];
}
```

Validations métier supplémentaires (souvent dans le service) :
- véhicule disponible (`is_available=true`)
- durée min 1 jour

---

## 5) Service Layer

### `app/Services/ReservationService.php`
Responsabilités :
- Calcul de durée (`total_days`)
- Estimation (`estimated_total`)
- Création de la réservation (`status=pending`)
- Émission de notifications (optionnel, peut être déplacé en Events)

Exemples de méthodes :
- `calculateDays(string|Carbon $start, string|Carbon $end): int`
- `estimateTotal(int $days, Vehicle $vehicle): int`
- `create(array $payload, Vehicle $vehicle): Reservation`

---

## 6) Repositories (optionnel V1)

À utiliser si :
- requêtes complexes
- besoin de swap (API/DB)

Sinon, Eloquent + scopes suffisent.

---

## 7) Middleware

### `AdminAuth`
- Protéger `/admin/*`
- Autoriser uniquement les utilisateurs admin (guard dédié ou middleware `can:admin`)

### Rate limiting
- Limiter `POST /reservation` (anti-spam)

---

## 8) Routes

### Public
```php
Route::get('/', [HomeController::class,'index']);
Route::get('/ville/{slug}', [HomeController::class,'showCity']);
Route::get('/voiture/{slug}', [HomeController::class,'showVehicle']);
Route::post('/reservation', [ReservationController::class,'store']);
```

### Admin (exemple)
```php
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    // vehicles CRUD
    // reservations listing + update status
});
```

---

## 9) Observabilité (recommandations)
- Logs : erreurs de validation métier, tentatives de spam
- Notifications : email admin pour nouvelle demande
- Audit : historique des changements de statut (future V2)
