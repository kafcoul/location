# Backlog — CKF Motors (MVP)

## Objectif
Lister les user stories et tâches MVP pour livrer vite une V1 stable orientée génération de demandes.

---

## 1) MVP — User Stories (priorité haute)

### US-01 — Voir les villes
**En tant que** visiteur, **je veux** voir Paris et Abidjan sur la homepage **afin de** accéder au catalogue.
- Critères d’acceptation :
  - Homepage affiche 2 CTA villes
  - Chaque ville mène à `/ville/{slug}`

### US-02 — Voir les véhicules d’une ville
**En tant que** visiteur, **je veux** voir la liste des véhicules d’une ville **afin de** choisir.
- Critères :
  - Filtre par `city.slug`
  - Afficher prix/jour + disponibilité

### US-03 — Voir la fiche véhicule
**En tant que** visiteur, **je veux** consulter un véhicule **afin de** décider de réserver.
- Critères :
  - Nom, description, image, prix/jour, caution
  - Bouton Réserver

### US-04 — Estimer un prix selon dates
**En tant que** visiteur, **je veux** définir mes dates **afin de** voir une estimation.
- Critères :
  - `total_days` >= 1
  - `estimated_total = total_days * price_per_day`

### US-05 — Soumettre une demande de réservation
**En tant que** visiteur, **je veux** envoyer ma demande **afin de** être recontacté.
- Critères :
  - Validation dates + email + téléphone
  - `status=pending`
  - Confirmation à l’écran

### US-06 — Admin: gérer véhicules
**En tant que** admin, **je veux** CRUD les véhicules **afin de** gérer le catalogue.
- Critères :
  - Créer / éditer / supprimer
  - Toggle `is_available`

### US-07 — Admin: traiter les demandes
**En tant que** admin, **je veux** voir les demandes et changer le statut **afin de** confirmer.
- Critères :
  - Liste filtrable par statut
  - Actions `confirmed` / `cancelled`

---

## 2) Endpoints / Routes (V1)

### Public
- `GET /`
- `GET /ville/{slug}`
- `GET /voiture/{slug}`
- `POST /reservation`

### Admin (suggestion)
- `GET /admin`
- `GET /admin/vehicles`
- `GET /admin/vehicles/create`
- `POST /admin/vehicles`
- `GET /admin/vehicles/{id}/edit`
- `PUT/PATCH /admin/vehicles/{id}`
- `DELETE /admin/vehicles/{id}`
- `GET /admin/reservations`
- `PATCH /admin/reservations/{id}/status`

---

## 3) Tâches techniques (MVP)

### Core
- Migrations + seeders (Paris/Abidjan)
- Models + relations
- Form request `StoreReservationRequest`
- `ReservationService`

### Sécurité
- CSRF
- Validation
- Rate limit sur réservation
- Middleware admin

### Qualité
- Tests :
  - calcul jours (min 1)
  - validation dates
  - création réservation `pending`

---

## 4) Definition of Done (DoD)

- Parcours public complet : ville → véhicules → fiche → réservation
- La demande est enregistrée et visible en admin
- Admin peut changer le statut
- Erreurs de validation affichées proprement
- Pages publiques chargent vite (images optimisées)
