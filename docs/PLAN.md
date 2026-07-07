# GymFlow — Execution Plan

## Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel (latest) |
| Templating | Blade |
| CSS | TailwindCSS |
| JS Interactivity | Alpine.js |
| Auth starter | Laravel Breeze (Blade) |
| Roles | spatie/laravel-permission |
| DB (dev) | PostgreSQL — Docker |
| Mail dev | Mailpit — Docker |
| Payment | Midtrans Sandbox |
| QR | simplesoftwareio/simple-qrcode |
| Queue | Database driver (bawaan) |
| Deploy | Docker |

## Dev Environment

```
docker compose up -d       → PostgreSQL :5432 + Mailpit :8025
php artisan serve          → Laravel :8000
npm run dev                → Vite/TailwindCSS :5173
```

## Database Schema

```
users                     ─── model_has_roles (Spatie) ─── roles (Spatie)
─────────────────────
id
name
email
password
phone (nullable)
avatar (nullable)
role (enum: admin|trainer|member)
remember_token
timestamps

membership_plans          membership          (1 user = 1 active membership)
─────────────────────     ─────────────
id                        id
name                      user_id (FK)
duration_month            plan_id (FK)
price                     start_date
description               end_date
is_active (bool)          status (active|expired|cancelled)
timestamps                timestamps

orders                    payments
─────────────────────     ────────────
id                        id
user_id (FK)              order_id (FK)
plan_id (FK)              amount
amount                    midtrans_order_id
status (enum)             midtrans_transaction_status
midtrans_snap_token       payment_type
timestamps                raw_response (json)
                          paid_at
                          timestamps

attendance                          workout_plans
─────────────────────              ───────────────
id                                 id
user_id (FK)                       trainer_id (FK user)
check_in_time                      member_id (FK user)
date                               title
timestamps                         timestamps

exercise_logs                      classes         bookings
─────────────────────              ──────────      ─────────
id                                 id              id
plan_id (FK)                       name            class_id (FK)
exercise_name                      trainer_id (FK) user_id (FK member)
sets                               schedule (datetime) status (booked|cancelled)
reps                               capacity        timestamps
weight                             timestamps
notes
timestamps
```

## Directory Structure

```
gymweb/
├── app/
│   ├── Models/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Trainer/
│   │   │   ├── Member/
│   │   │   └── Auth/
│   │   └── Middleware/
│   ├── Services/
│   └── Mail/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   │   ├── guest.blade.php
│   │   ├── member.blade.php
│   │   ├── admin.blade.php
│   │   └── trainer.blade.php
│   ├── components/
│   │   ├── midtrans-snap.blade.php
│   │   └── stat-card.blade.php
│   ├── auth/
│   ├── admin/
│   ├── member/
│   └── trainer/
├── docker/
│   ├── compose.yml
│   ├── Dockerfile
│   └── nginx/
├── routes/
│   └── web.php
└── tests/
```

## Routes

```
# Public
GET   /                         Landing page
GET   /pricing                  Pricing page
# Auth (Breeze)
GET   /login                    Login
POST  /login
POST  /logout
GET   /register                 Register
POST  /register
GET   /forgot-password
POST  /forgot-password
GET   /reset-password/{token}
POST  /reset-password

# Member (prefix: /dashboard)
GET   /dashboard
GET   /dashboard/membership
GET   /dashboard/payment-history
GET   /dashboard/workout
GET   /dashboard/classes
POST  /dashboard/classes/{class}/book
DELETE /dashboard/bookings/{booking}
GET   /dashboard/profile
PUT   /dashboard/profile

# Checkout (member only)
POST  /checkout/{plan}
GET   /checkout/{order}/pay
GET   /checkout/success
GET   /checkout/failed

# Attendance (member only)
GET   /attendance
GET   /attendance/qr

# Webhook (public, no CSRF)
POST  /webhook/midtrans

# Admin (prefix: /admin)
GET   /admin/dashboard
GET   /admin/members
GET   /admin/members/{id}
GET   /admin/plans
POST  /admin/plans
PUT   /admin/plans/{id}
DELETE /admin/plans/{id}
GET   /admin/payments
GET   /admin/reports
POST  /admin/attendance/scan

# Trainer (prefix: /trainer)
GET   /trainer/dashboard
GET   /trainer/workout-plans
POST  /trainer/workout-plans
PUT   /trainer/workout-plans/{id}
DELETE /trainer/workout-plans/{id}
POST  /trainer/workout-plans/{plan}/logs
GET   /trainer/members/{member}/progress
```

## Execution Phases

### Fase 1: Foundation

| # | Task |
|---|------|
| 1 | Scaffold project: `laravel new gymweb` + PostgreSQL + Breeze (Blade) + TailwindCSS |
| 2 | Docker compose: PostgreSQL + Mailpit |
| 3 | Install `spatie/laravel-permission` |
| 4 | Migrations: users, membership_plans, Spatie roles |
| 5 | Seeders: admin user, 3 plans, 3 roles |
| 6 | Auth customization: auto assign role on register, redirect by role after login |
| 7 | Middleware: role:admin, role:member, role:trainer |
| 8 | Layouts: guest, member, admin, trainer (Blade) |
| 9 | Admin CRUD: membership plans |
| 10 | Admin dashboard: stats + member list + search/filter |
| 11 | Admin: member detail page |
| 12 | Public pages: landing + pricing |
| 13 | Member dashboard: welcome + membership status |

### Fase 2: Business Logic

| # | Task |
|---|------|
| 14 | Migrations: orders, payments, membership |
| 15 | `PaymentService`: generate Midtrans Snap token |
| 16 | Checkout flow: select plan → create order → pay page |
| 17 | Midtrans Snap embed: popup on pay page |
| 18 | Webhook handler: update payment, activate membership |
| 19 | `MembershipService`: activate, expire, check status |
| 20 | Payment history: member view + admin view |
| 21 | Migration: attendance |
| 22 | QR attendance: generate + scan + record |
| 23 | Attendance history: member dashboard + admin per member |

### Fase 3: Advanced

| # | Task |
|---|------|
| 24 | Migrations: workout_plans, exercise_logs |
| 25 | Trainer: CRUD workout plans + exercise logs |
| 26 | Trainer: assign member to plan |
| 27 | Member: view workout progress |
| 28 | Migrations: classes, bookings |
| 29 | Admin: create/manage classes |
| 30 | Member: book/cancel classes, capacity guard |
| 31 | Email notifications: membership expiring, payment confirm, class reminder |
| 32 | Queue jobs: send emails async |
| 33 | Admin reports: revenue chart, member growth, attendance stats |
| 34 | Profile page: all roles, edit name/phone/avatar/password |
| 35 | Docker production: Dockerfile + compose.prod.yml |
| 36 | Tests: feature + unit (auth, checkout, webhook, booking) |

## Services (Business Logic)

```
app/Services/
├── MembershipService.php     # activate, expire, check status
├── PaymentService.php        # generate Snap token, handle webhook
├── AttendanceService.php     # QR generate, validate, record check-in
├── BookingService.php        # book class, check capacity, cancel
├── WorkoutService.php        # CRUD plans, logs
└── NotificationService.php   # send email reminders
```

## Packages

```
spatie/laravel-permission    # Role-based access
midtrans/midtrans-php        # Payment gateway
simplesoftwareio/simple-qrcode  # QR generator
chart.js (CDN)               # Admin reports chart
html5-qrcode (CDN)           # QR scanner di browser
```

## Notes

- Tanpa React, Inertia, atau JS framework tambahan. Full Blade + TailwindCSS + Alpine.js.
- Tanpa library komponen UI (shadcn, Flowbite, dsb). Tailwind utility langsung.
- Dev: Laravel + Vite di host, PostgreSQL + Mailpit di Docker.
- Prod: Full Docker (PHP-FPM + Nginx + PostgreSQL).
- Queue pakai database driver bawaan — cukup untuk webhook & email.
