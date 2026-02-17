# Business Logic — Réservations & Pricing

## Objectif
Centraliser les règles métier pour :
- calcul de durée
- calcul de l’estimation
- validations
- statuts et transitions

---

## 1) Durée de réservation

### Règle
- $total\_days$ = nombre de jours entre `start_date` et `end_date`.
- Minimum : **1 jour**.

### Référence Carbon
```php
$days = Carbon::parse($start)->diffInDays($end);
$days = max(1, $days);
```

### Cas à clarifier (recommandation)
- Si le client choisit 10 → 11 (1 nuit), `diffInDays` = 1 : OK.
- Si le même jour est autorisé côté UI, alors `diffInDays` = 0, on force à 1.

---

## 2) Estimation du prix

### Règle
```php
$total = $days * $vehicle->price_per_day;
```

### Notes
- En V1, l’estimation n’est pas un paiement.
- Les remises/promo ne sont pas incluses (prévu future version).

---

## 3) Disponibilité véhicule

### Règle V1
- Un véhicule doit avoir `is_available = true` pour accepter une demande.

### Extension future (non incluse V1)
- Blocage par calendrier (éviter chevauchement avec réservations confirmées).

---

## 4) Validation des dates

### Règles
- `start_date >= today`
- `end_date > start_date`

### Messages d’erreur (UX)
- Start < today : « La date de début doit être aujourd’hui ou plus tard. »
- End <= start : « La date de fin doit être après la date de début. »

---

## 5) Statuts de réservation

### Valeurs
- `pending` : demande reçue, en attente de traitement admin
- `confirmed` : validée manuellement
- `cancelled` : annulée (par admin)

### Transitions autorisées (V1)
- `pending` → `confirmed`
- `pending` → `cancelled`
- (Optionnel) `confirmed` → `cancelled` (si besoin opérationnel)

---

## 6) Création d’une réservation (contract)

### Input minimal (depuis formulaire)
- `vehicle_id` ou `vehicle_slug`
- `full_name`
- `phone`
- `email`
- `start_date`
- `end_date`

### Output
- Enregistrement `reservations` créé avec :
  - `total_days`
  - `estimated_total`
  - `status = pending`

### Effets de bord
- Notification admin (email +/ou dashboard)
- Rate limiting (anti-spam)

---

## 7) Recommandation d’implémentation (Service Layer)

Créer `ReservationService` avec méthodes typiques :
- `calculateDays($start, $end): int`
- `estimateTotal(int $days, Vehicle $vehicle): int`
- `createReservation(array $payload, Vehicle $vehicle): Reservation`
