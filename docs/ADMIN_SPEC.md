# Admin Spec — CKF Motors

## Objectif
Spécifier les fonctionnalités admin : gestion des véhicules, supervision des réservations, mise à jour des statuts.

---

## 1) Accès & sécurité

### Authentification
- Zone admin sous `/admin`.
- Accès protégé par middleware `AdminAuth`.

### Permissions (V1)
- Rôle unique : **admin**.
- Droits : CRUD véhicules, lecture/édition réservations.

---

## 2) Écrans (V1)

### 2.1 Dashboard
**Objectif :** visualiser rapidement l’activité.

Widgets recommandés :
- # réservations `pending`
- # réservations `confirmed`
- # réservations `cancelled`
- (Optionnel) réservations des 7 derniers jours

Actions rapides :
- « Voir demandes en attente »
- « Ajouter un véhicule »

---

### 2.2 Véhicules — Listing
Colonnes :
- Ville
- Nom
- Prix/jour
- Caution
- Disponible (toggle)
- Dernière MAJ
- Actions : Voir / Éditer / Supprimer

Filtres :
- Ville
- Disponibilité

---

### 2.3 Véhicules — Création / édition
Champs :
- Ville (`city_id`)
- Nom
- Slug (auto depuis le nom)
- Prix/jour
- Caution
- Description
- Image (upload)
- Disponible (checkbox)

Règles :
- Image : vérifier type MIME + taille, stocker via `storage`.

---

### 2.4 Réservations — Listing
Colonnes :
- Date création
- Véhicule
- Ville (via véhicule)
- Client (nom)
- Téléphone
- Email
- Période (start → end)
- Durée (jours)
- Estimation
- Statut
- Actions : Détails / Changer statut

Filtres :
- Statut
- Ville
- Intervalle dates (optionnel)

---

### 2.5 Réservation — Détails
Afficher :
- Infos demandeur
- Infos véhicule
- Dates
- Estimation
- Notes

Actions :
- Passer à `confirmed`
- Passer à `cancelled`

---

## 3) Règles de statut

- Valeurs : `pending`, `confirmed`, `cancelled`
- Transitions V1 :
  - `pending` → `confirmed`
  - `pending` → `cancelled`
  - (Optionnel) `confirmed` → `cancelled`

---

## 4) Notifications

### 4.1 Nouvelle demande
- À la création d’une réservation : notifier l’admin.

Canaux possibles :
- Email
- (Optionnel) Notification interne (dashboard)

---

## 5) Audit & historique (future V2)

- Historiser les changements de statut (qui, quand, pourquoi)
- Ajouter un champ `admin_note` (raison annulation, etc.)
