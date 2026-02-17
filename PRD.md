# PRD — CKF Motors (Location Premium)

**Date :** 12 février 2026  
**Projet :** CKF Motors  
**Positionnement :** Location de véhicules premium — **Abidjan**  
**Paiement :** Sur place uniquement (dépôt de garantie à la remise du véhicule)

---

## 1) Contexte & objectifs

### 1.1 Vision
Proposer une expérience simple et premium de location de véhicules à Abidjan, avec un parcours rapide menant à une **demande de réservation qualifiée**.

### 1.2 Objectif principal (North Star)
Transformer les visiteurs en **demandes de réservation** (créées en base, statut `pending`) puis **confirmées manuellement** par l’admin.

### 1.3 Proposition de valeur
- Catalogue clair par ville (Abidjan)
- Prix par jour affiché et estimation automatique
- Réservation en quelques étapes
- Paiement sur place

---

## 2) Hypothèses & contraintes

### 2.1 Hypothèses
- Les véhicules sont rattachés à une ville.
- L’utilisateur peut consulter le catalogue sans compte.
- La confirmation est **manuelle** par l’admin.

### 2.2 Contraintes
- Paiement **sur place** uniquement (pas de paiement en ligne dans cette V1).
- Dépôt de garantie collecté à la remise du véhicule.

---

## 3) Personae & besoins

### 3.1 Client (visiteur)
- Cherche rapidement une voiture premium selon la ville
- Veut connaître le prix estimé sur une période
- Veut réserver sans friction

### 3.2 Admin (gestionnaire)
- Gère le listing des véhicules (prix, disponibilité, description, images)
- Consulte les demandes de réservation
- Confirme / annule les demandes

---

## 4) Parcours utilisateurs (User Flows)

### 4.1 Flow 1 — Navigation simple
1. Arrive sur la Homepage
2. Clique sur **Abidjan**
3. Consulte la liste des véhicules
4. Clique **Réserver** sur un véhicule
5. Remplit le formulaire
6. Reçoit une confirmation à l’écran
7. Admin reçoit une notification

### 4.2 Flow 2 — Réservation (avec dates + estimation)
1. Choisit des dates (début/fin)
2. Calcul automatique : durée + estimation de prix
3. Renseigne ses informations
4. Soumet
5. La réservation est créée avec `status = pending`
6. Admin confirme manuellement (passe en `confirmed`) ou annule (`cancelled`)

---

## 5) Données & base de données (Database Design)

### 5.1 Table `cities`
Champs :
- `id`
- `name` Abidjan
- `slug`
- `created_at`

### 5.2 Table `vehicles`
Champs :
- `id`
- `city_id` (FK)
- `name`
- `slug`
- `price_per_day`
- `deposit_amount`
- `description`
- `image`
- `is_available` (boolean)
- `created_at`
- `updated_at`

### 5.3 Table `reservations`
Champs :
- `id`
- `vehicle_id` (FK)
- `full_name`
- `phone`
- `email`
- `start_date`
- `end_date`
- `total_days`
- `estimated_total`
- `status` (`pending`, `confirmed`, `cancelled`)
- `notes`
- `created_at`
- `updated_at`

---

## 6) Règles métier (Business Logic)

### 6.1 Calcul de durée
- Basé sur Carbon
- Minimum = 1 jour

Référence :
```php
$days = Carbon::parse($start)->diffInDays($end);
```

> Note : si `diffInDays()` retourne `0` sur une même journée, appliquer un minimum à `1`.

### 6.2 Calcul estimation
```php
$total = $days * $vehicle->price_per_day;
```

### 6.3 Validation
- `start_date >= today`
- `end_date > start_date`
- `vehicle.is_available = true`

---

## 7) Admin (back-office) — besoins & actions

L’admin peut :
- Ajouter un véhicule
- Modifier les prix
- Activer / désactiver la disponibilité (`is_available`)
- Voir les réservations
- Changer le statut : `pending` → `confirmed` / `cancelled`

---

## 8) Architecture Laravel (V1 production ready)

### 8.1 Structure dossiers
```txt
app/
 ├── Models/
 ├── Http/
 │    ├── Controllers/
 │    ├── Requests/
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

### 8.2 Modèles (Eloquent)
#### `City`
- `fillable`: `name`, `slug`
- Relation: `hasMany(Vehicle)`

#### `Vehicle`
- `fillable`: `city_id`, `name`, `slug`, `price_per_day`, `deposit_amount`, `description`, `image`, `is_available`
- Relations: `belongsTo(City)`, `hasMany(Reservation)`

#### `Reservation`
- `fillable`: `vehicle_id`, `full_name`, `phone`, `email`, `start_date`, `end_date`, `total_days`, `estimated_total`, `status`, `notes`
- Relation: `belongsTo(Vehicle)`

### 8.3 Controllers
#### `HomeController`
- `index()` — homepage + accès villes
- `showCity($slug)` — liste véhicules par ville
- `showVehicle($slug)` — détail véhicule + CTA réserver

#### `ReservationController`
- `store()` — création réservation (`pending`) + notification admin

#### `AdminController`
- `dashboard()`
- CRUD vehicles
- Listing reservations
- Update status

### 8.4 Routes (web)
```php
Route::get('/', [HomeController::class,'index']);

Route::get('/ville/{slug}', [HomeController::class,'showCity']);
Route::get('/voiture/{slug}', [HomeController::class,'showVehicle']);

Route::post('/reservation', [ReservationController::class,'store']);
```

### 8.5 Validation (Form Request)
Créer `StoreReservationRequest`.
Règles attendues :
```php
public function rules()
{
    return [
        'full_name' => 'required|string',
        'phone' => 'required',
        'email' => 'required|email',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date'
    ];
}
```

### 8.6 Service Layer
Créer `app/Services/ReservationService.php`.
Responsabilités :
- Calcul des jours
- Calcul du total estimé
- Création réservation
- Gestion du statut (si besoin)

### 8.7 Middleware
- `AdminAuth` (accès admin)
- Rate limiting sur le endpoint de réservation (anti-spam)

---

## 9) Sécurité (baseline)

- CSRF activé
- Validation backend obligatoire
- Escape output Blade
- Upload image sécurisé (MIME + taille + stockage)
- HTTPS obligatoire en prod

---

## 10) SEO & performance

- Meta dynamiques par ville
- Slugs propres (cities/vehicles)
- Sitemap automatique
- Images optimisées (WebP)
- Cache Laravel (pages publiques, config, routes)

---

## 11) Scalabilité (roadmap)

Prévu pour :
- Ajout de nouvelles villes
- Ajout paiement d’acompte
- Multi-langue
- API mobile
- CRM intégré

---

## 12) Critères d’acceptation (V1)

- Un visiteur peut :
  - Naviguer par ville
  - Voir véhicules disponibles
  - Estimer un prix selon dates
  - Soumettre une demande
- Une réservation est créée avec :
  - `total_days` cohérent (min 1)
  - `estimated_total` correctement calculé
  - `status = pending`
- L’admin peut consulter les réservations et changer leur statut.
