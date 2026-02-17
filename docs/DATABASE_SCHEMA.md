# Database Schema — CKF Motors

## Objectif
Définir les tables, relations et contraintes pour :
- Villes
- Véhicules
- Réservations

---

## ERD (logique)
- `cities` 1—N `vehicles`
- `vehicles` 1—N `reservations`

---

## Table: `cities`

### Colonnes
- `id` (PK)
- `name` (string, unique idéalement)
- `slug` (string, unique)
- `created_at` (timestamp)
- `updated_at` (timestamp) *(recommandé même si non listé dans le workflow initial)*

### Index & contraintes
- Unique: `slug`
- (Optionnel) Unique: `name`

---

## Table: `vehicles`

### Colonnes
- `id` (PK)
- `city_id` (FK → `cities.id`, index)
- `name` (string)
- `slug` (string, unique)
- `price_per_day` (integer ou decimal) — montant par jour
- `deposit_amount` (integer ou decimal) — caution
- `description` (text)
- `image` (string) — chemin fichier/URL
- `is_available` (boolean, default true)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Index & contraintes
- FK: `city_id` references `cities(id)`
- Unique: `slug`
- Index: `city_id`, `is_available` (utile pour filtrer)

### Notes
- Recommandation : stocker les montants en **centimes** (int) pour éviter les erreurs de flottants.

---

## Table: `reservations`

### Colonnes
- `id` (PK)
- `vehicle_id` (FK → `vehicles.id`, index)
- `full_name` (string)
- `phone` (string)
- `email` (string)
- `start_date` (date)
- `end_date` (date)
- `total_days` (integer)
- `estimated_total` (integer ou decimal)
- `status` (enum/string) : `pending`, `confirmed`, `cancelled`
- `notes` (text, nullable)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Index & contraintes
- FK: `vehicle_id` references `vehicles(id)`
- Index: `vehicle_id`
- Index: `status`
- Index: `start_date`, `end_date` (optionnel)

### Notes
- `estimated_total` correspond à l’estimation calculée au moment de la demande.
- Le pricing final peut évoluer : garder l’estimation “historique”.

---

## Conventions Laravel (migrations)

### Defaults recommandés
- `timestamps()` sur toutes les tables
- `softDeletes()` sur `vehicles` et/ou `reservations` (optionnel)

### Enum status
- En V1, un champ `string` + validation applicative suffit.
- En MySQL, un `enum` peut être utilisé mais complique parfois les migrations multi-SGBD.
