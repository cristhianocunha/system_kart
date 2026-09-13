# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

System Kart is a Laravel 11 application for managing kart racing data. It records heat (bateria) results for registered drivers, tracks lap times, and maintains a championship-wide ranking with scoring.

## Commands

**Start development (all services concurrently):**
```bash
composer run dev
```
This starts: PHP dev server, queue worker, log tailing (Pail), and Vite — all in one command.

**Individual services:**
```bash
php artisan serve          # HTTP server
npm run dev                # Vite frontend assets
php artisan queue:listen   # Queue worker (needed for ranking jobs)
```

**Database:**
```bash
php artisan migrate
php artisan migrate:fresh --seed
```

**Tests:**
```bash
php artisan test                                     # All tests
php artisan test --filter=AuthenticationTest         # Single test class
php artisan test tests/Feature/AuthenticationTest.php  # By file path
```

**Code style:**
```bash
./vendor/bin/pint   # Laravel Pint (PSR-12)
```

**Docker (Laravel Sail):**
```bash
./vendor/bin/sail up   # Uses docker-compose.yml (MySQL, Redis, Mailpit, Selenium)
```

## Architecture

### Authentication & Access Control

- Uses **Laravel Jetstream** (with Livewire) + **Fortify** for auth scaffolding — the `Actions/Fortify/` and `Actions/Jetstream/` directories contain the customizable auth logic.
- **Sanctum** tokens secure the REST API. The `/api/login` endpoint issues a token valid for 1 hour. All API routes require `auth:sanctum` middleware.
- Registration is open but only users with emails listed in the `ListEmailsValid` table can register — this is the allowlist gate.
- The `/api/login` route has a hardcoded restriction: it only authenticates `id = 1`, making it effectively a single admin API user.

### Core Data Flow

`Bateria01` is the central table — each row is one driver's result in one heat (corrida). Fields include: `POS` (position), `TMV` (best lap time), `MV` (best lap number), `TT` (total time), `TV` (total laps), `Kart`, `corrida` (race number), `date_corrida`, and `update_ranking` (timestamp used as a processed flag).

**Ranking update flow:**
1. API call to `POST /api/createrun` inserts rows into `bateria01` (via `UpdateRun::store`).
2. Optionally, `POST /api/updatepos/{corrida}` reorders positions for a corrida — it recalculates all positions by splice-and-renumber.
3. Authenticated web user hits `POST /ranking/update` → `RankingController::update()` → directly calls `ProcessRanking::handle()` synchronously (not dispatched to queue despite implementing `ShouldQueue`).
4. `ProcessRanking::handle()` reads all `bateria01` rows where `update_ranking IS NULL`, calculates points (10 for 1st down to 1 for 10th, 0 otherwise), upserts into `ranking` table, then stamps `update_ranking` with current datetime to mark them processed.
5. `ProcessRanking::updateTMV()` then updates each driver's best lap time in `ranking` from across all corridas.
6. `RankingController::destroy()` truncates `ranking` and resets all `update_ranking` to NULL, allowing a full recompute.

### Routes Summary

**Public web:**
- `GET /` — index page showing public ranking (via `IndexPage` → `RankingController::show`)

**Auth-protected web:**
- `GET /dashboard` — driver's personal stats (best lap time, list of all corridas)
- `GET /bateria01/{corrida}` — full results for a specific heat, ordered by position (NC at the end)
- `GET /ranking` — full championship ranking, ordered by points desc
- `POST /ranking/update` — trigger ranking recalculation
- `POST /ranking/destroy` — truncate ranking and reset processed flags

**API (Sanctum token required, except login):**
- `POST /api/login` — returns bearer token (admin user only)
- `POST /api/createrun` — insert a driver result for a heat
- `POST /api/updatepos/{corrida}` — update position ordering for a heat

### Frontend

Blade templates with **Livewire 3** components (from Jetstream). Assets compiled via **Vite** with Tailwind CSS. API documentation is in `doc_api/kart/` using Bruno format.

### Key Conventions

- `corrida` is an integer identifying a race/heat — it is the primary grouping key across the system.
- `update_ranking` being NULL means the row has not yet been counted in the ranking. It acts as a processing flag, not a soft-delete.
- `Bateria01::$rules` and `Bateria01::$rulesUpatePos` are static validation rule arrays referenced directly in controllers.
