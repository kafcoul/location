# CKF Motors — Location de Véhicules Premium à Abidjan

Application web complète de location de véhicules premium à Abidjan, développée avec Laravel 12.

---

## 🚀 Stack Technique

| Couche | Technologie |
|---|---|
| **Backend** | PHP 8.4, Laravel 12, Sanctum 4 |
| **Frontend** | Blade, Tailwind CSS, Vite |
| **Admin** | Filament v3 |
| **Base de données** | SQLite (dev) / MySQL (prod) |
| **Auth & Rôles** | Laravel Breeze, Spatie Permission |
| **Sécurité** | 2FA (Google2FA), rate limiting, audit log |
| **PDF** | barryvdh/laravel-dompdf |
| **PWA** | Service Worker, Manifest |
| **Tests** | PHPUnit (59 tests, 153 assertions) |

---

## 📦 Installation

```bash
# Cloner le projet
git clone https://github.com/kafcoul/location.git
cd location

# Installer les dépendances
composer install
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Créer la base SQLite
touch database/database.sqlite
php artisan migrate --seed

# Créer le lien de stockage
php artisan storage:link

# Lancer le serveur
php artisan serve --port=8080
npm run dev
```

---

## 🔑 Accès Admin

- **URL** : `/admin`
- **Email** : `admin@ckfmotors.com`
- **Mot de passe** : `password`

Rôles disponibles : Super Admin, Admin, Manager, Support

---

## 🌐 Pages Publiques

| Route | Description |
|---|---|
| `/` | Page d'accueil avec héro + catalogue |
| `/ville/{slug}` | Page ville avec véhicules disponibles |
| `/voiture/{slug}` | Détail véhicule (galerie, specs, prix) |
| `/voiture/{slug}/reservation` | Formulaire de réservation |
| `/faq` | Foire aux questions |
| `/accompagnement` | Page accompagnement |
| `/sitemap.xml` | Sitemap XML dynamique |
| `/robots.txt` | Fichier robots.txt |

---

## 📡 API REST (Sanctum)

Base URL : `/api`

### Endpoints publics

```
POST   /api/register              # Inscription
POST   /api/login                 # Connexion → token
GET    /api/vehicles              # Liste véhicules (filtres: city, brand, min_price, max_price, seats, gearbox)
GET    /api/vehicles/{slug}       # Détail véhicule
GET    /api/cities                # Liste villes
GET    /api/cities/{slug}         # Détail ville + véhicules
POST   /api/reservations          # Créer une réservation
```

### Endpoints authentifiés (Bearer Token)

```
GET    /api/me                           # Profil utilisateur
POST   /api/logout                       # Déconnexion
GET    /api/reservations                 # Mes réservations
GET    /api/reservations/{id}            # Détail réservation
PATCH  /api/reservations/{id}/cancel     # Annuler (si pending)
```

### Exemple d'utilisation

```bash
# Login
curl -X POST http://127.0.0.1:8080/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@ckfmotors.com","password":"password"}'

# Liste véhicules filtrés
curl http://127.0.0.1:8080/api/vehicles?city=abidjan&brand=Toyota&min_price=20000
```

---

## 🔍 SEO

- **Open Graph** + **Twitter Cards** sur toutes les pages
- **OG image dynamique** sur les pages véhicules
- **Sitemap XML** automatique (`/sitemap.xml`)
- **robots.txt** dynamique (`/robots.txt`)
- **Slugs** propres pour villes et véhicules

---

## 📱 PWA

- **Manifest** (`/manifest.json`) — mode standalone, couleurs CKF Motors
- **Service Worker** (`/sw.js`) — stratégie network-first avec cache fallback
- **Page offline** (`/offline.html`) — page hors-ligne brandée
- **Icônes** SVG dans `/public/images/icons/`

---

## 🛡️ Sécurité

- Authentification 2FA (Google Authenticator)
- Rate limiting sur les formulaires
- Audit log (Spatie Activity Log)
- CSRF, validation backend, escape Blade
- HTTPS forcé en production

---

## 🧪 Tests

```bash
# Lancer tous les tests
php artisan test

# Lancer une suite spécifique
php artisan test --filter=AuthApiTest
php artisan test --filter=VehicleApiTest
php artisan test --filter=ReservationApiTest
php artisan test --filter=SeoTest
php artisan test --filter=VehicleModelTest
php artisan test --filter=ReservationModelTest
```

| Suite | Tests | Couverture |
|---|---|---|
| `AuthApiTest` | 8 | Register, login, logout, profil |
| `VehicleApiTest` | 10 | CRUD, filtres, villes |
| `ReservationApiTest` | 8 | Création, validation, annulation |
| `PageTest` | 12 | Toutes les pages publiques + 404 |
| `SeoTest` | 8 | Sitemap, robots, OG, PWA |
| `VehicleModelTest` | 7 | Relations, scopes, casts |
| `ReservationModelTest` | 6 | Relations, statuts, casts |

---

## 📁 Structure du Projet

```
app/
├── Filament/           # Admin Panel (Filament v3)
├── Http/
│   ├── Controllers/    # Web + API controllers
│   ├── Requests/       # Form Requests
│   └── Resources/      # API Resources (JSON)
├── Models/             # Eloquent models
├── Notifications/      # Email notifications
├── Policies/           # Authorization policies
└── Services/           # Business logic

resources/views/
├── layouts/            # Layout public
├── pages/              # Pages Blade
├── components/         # Composants réutilisables
└── seo/                # Sitemap template

tests/
├── Feature/Api/        # Tests API REST
├── Feature/            # Tests pages + SEO
└── Unit/               # Tests modèles
```

---

## 💰 Devise

Toutes les valeurs monétaires sont en **FCFA** (Franc CFA).

---

## 📄 Licence

Projet privé — CKF Motors © 2026