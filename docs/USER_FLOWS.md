# User Flows — CKF Motors

## Objectif
Décrire les parcours utilisateurs principaux menant à une **demande de réservation qualifiée**.

---

## Flow 1 — Navigation simple (découverte → réservation)

### Préconditions
- Le site est accessible.
- Les villes **Paris** et **Abidjan** existent.
- Des véhicules sont publiés (et potentiellement marqués `is_available=true`).

### Étapes
1. L’utilisateur arrive sur la **Homepage**.
2. Il choisit une ville : **Paris** ou **Abidjan**.
3. Il consulte la liste des véhicules de la ville.
4. Il clique sur un véhicule pour accéder à la fiche.
5. Il clique sur **Réserver**.
6. Il remplit le formulaire de demande (identité + dates).
7. Il soumet.
8. Il voit un écran de confirmation (réservation enregistrée, paiement sur place).
9. L’admin reçoit une notification (email / dashboard).

### Résultat attendu
- Une `reservation` est créée en base avec `status=pending`.

---

## Flow 2 — Réservation (dates → estimation → soumission)

### Préconditions
- Véhicule existant.
- Véhicule disponible : `is_available=true`.

### Étapes
1. L’utilisateur sélectionne `start_date` et `end_date`.
2. Le système calcule :
   - `total_days`
   - `estimated_total`
3. L’utilisateur renseigne :
   - `full_name`
   - `phone`
   - `email`
4. Il soumet la demande.
5. Le système valide les données.
6. Le système enregistre la réservation avec `status=pending`.
7. L’admin confirme manuellement :
   - `pending` → `confirmed`
   - ou `pending` → `cancelled`

### Résultat attendu
- L’utilisateur comprend que :
  - le montant affiché est une **estimation**,
  - le paiement s’effectue **sur place**,
  - la confirmation est **manuelle**.

---

## Edge cases (à gérer)

- Dates invalides : `end_date <= start_date`
- `start_date < today`
- Estimation : durée calculée à 0 jour (forcer min à 1)
- Véhicule indisponible (`is_available=false`) → empêcher la création
- Spam / abus sur le formulaire → rate limit

---

## Messages UX recommandés

- Confirmation : « Votre demande a été enregistrée. Nous vous contactons rapidement pour confirmer. Paiement sur place. »
- Véhicule indisponible : « Ce véhicule est momentanément indisponible. »
- Erreur dates : « Vérifiez les dates sélectionnées. »
