# SEO & Performance — CKF Motors

## Objectif
Améliorer la visibilité (SEO local) et la vitesse (Core Web Vitals) pour maximiser les demandes de réservation.

---

## 1) SEO — pages & contenu

### 1.1 Pages principales
- Homepage (`/`)
- Page Ville (`/ville/{slug}`)
- Page Véhicule (`/voiture/{slug}`)

### 1.2 Meta dynamiques
#### Ville
- `<title>` : `Location voiture premium à {Ville} | CKF Motors`
- `meta description` : 150–160 chars, services + paiement sur place

#### Véhicule
- `<title>` : `{Véhicule} — Location à {Ville} | CKF Motors`
- `meta description` : prix/jour, dépôt, CTA réservation

### 1.3 Slugs propres
- `cities.slug` : `abidjan`
- `vehicles.slug` : `range-rover-sport`, etc.

---

## 2) Données structurées (recommandé)

- JSON-LD `LocalBusiness` (si agence physique, adresse, téléphone)
- JSON-LD `Product` (véhicule) : nom, image, description, offers (price per day)

---

## 3) Sitemap & robots

### Sitemap
- Générer automatiquement les URLs :
  - villes
  - véhicules

### robots.txt
- Autoriser indexation pages publiques
- Bloquer `/admin/*`

---

## 4) Images

- Convertir en WebP (et garder fallback si nécessaire)
- Dimensions stables (éviter CLS)
- Lazy-load sur listes

---

## 5) Cache & perf Laravel

### Caches
- `config:cache`, `route:cache`, `view:cache` en prod
- Cache des pages publiques (optionnel) :
  - page ville
  - page véhicule

### DB
- Index sur `vehicles.city_id`, `vehicles.is_available`, `reservations.status`

---

## 6) Frontend perf (Blade)

- CSS minimal, bundling (Vite)
- Préchargement image hero (si utile)
- Pagination/limite sur listing véhicules si catalogue grand

---

## 7) SEO local (Abidjan)

- Pages dédiées par ville avec contenu unique
- Sections FAQ (paiement sur place, caution, conditions)
- Données de contact visibles
