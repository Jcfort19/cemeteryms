# CemeteryMS

CemeteryMS is a Laravel 12 cemetery management system with role-based web operations and a connected mobile collector PWA.

## Included

- Breeze authentication, forgot password, profile management, session timeout middleware, and audit logging.
- Spatie roles and permissions for Semi Admin, Cashier, Staff, Guard, Collector, and Family.
- Cemetery sections/lots with Leaflet-ready polygon data and status colors.
- Client records, deceased records, billing, cash payments, QR ID generation, PDF receipts, reports, reservations, memorial pages, visitor logs, SMS notification queueing, and collector mobile sync tables.
- Sanctum API for collector login, dashboard, QR validation, payment posting, and offline sync.
- Dark navy Tailwind UI, sidebar navigation, responsive dashboards, and installable PWA manifest/service worker.

## Local Setup

```bash
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

The local `.env` uses SQLite for quick testing. `.env.example` is configured for MySQL as the production-oriented default.

## Seeded Accounts

All seeded accounts use the password `password`.

- `admin@cemeteryms.test` - Semi Admin
- `cashier@cemeteryms.test` - Cashier
- `staff@cemeteryms.test` - Staff
- `guard@cemeteryms.test` - Guard
- `collector@cemeteryms.test` - Collector

## Verification

```bash
php artisan test
vendor/bin/pint --dirty
```
