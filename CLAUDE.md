# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies and bootstrap the project
composer run setup        # composer install + key:generate + migrate + npm install + build

# Development server (runs server, queue, logs, and vite concurrently)
composer run dev

# Run tests (clears config cache first)
composer run test

# Run a single test file
php artisan test --filter=ExampleTest

# Code style (Laravel Pint)
./vendor/bin/pint

# Regenerate IDE helper files after adding models or facades
php artisan ide-helper:generate
php artisan ide-helper:models

# Storage symlink (required after fresh install)
php artisan storage:link
```

## Stack

- **Laravel 12**, PHP 8.2+
- **Database**: PostgreSQL (`secretary_v2`)
- **Auth**: Laravel Sanctum + custom `HasAuthToken` trait (dual-token: access 15 min, refresh 7 days)
- **Tests**: Pest (SQLite in-memory)
- **API docs**: l5-swagger (OpenAPI annotations in controllers)
- **File storage**: `public` disk → `storage/app/public`, accessible at `APP_URL/storage`

## Architecture

Every module follows the same four-layer pattern:

```
FormRequest  →  DTO  →  Controller  →  Service  →  Model
```

- **FormRequest** validates the HTTP input (body fields + file rules).
- **DTO** (`app/DTOs/{Module}/`) is a `readonly` class built via `fromRequest()`. It is the only thing passed to the service — the controller never passes raw request data.
- **Controller** (`app/Http/Controllers/ApiController/{Module}/`) injects the service, builds the DTO, and returns a JSON response. Response shape: `{ type, message?, data? }`.
- **Service** (`app/Services/`) holds all business logic. It receives typed DTOs and resolved Eloquent models (never raw IDs). It returns API Resources.
- **Resource** (`app/Http/Resources/`) transforms model instances into the JSON response shape.

Route Model Binding is used throughout — route parameters like `{defenseReport}` are automatically resolved to model instances by Laravel, returning 404 if not found. The service never queries by ID itself.

## Key Conventions

**Enums** — `app/Enums/FiliereType` (Master/Licence) and `OptionType` (AL/SRC/SI/IA) are backed string enums. In DTOs use `FiliereType::from($data['filiere'])` to cast from validated string input. In services, store with `->value` to persist the string.

**File uploads** — always stored on the `public` disk under `uploads/{module}/`. The stored path is persisted in the DB. Resources expose a `file_url` via `Storage::disk('public')->url($this->path_column)`. On update/delete, remove the old file with `Storage::disk('public')->delete($path)`.

**Partial updates** — `UpdateDTO` fields are all nullable. In service `update()`, build `$updateData` with `array_filter([...], fn($v) => $v !== null)` then apply with `$model->fill($updateData)->save()` (not `$model->update()` — Intelephense false-positive on that method).

**Deleting** — use `ModelClass::destroy($model->id)` instead of `$model->delete()` to avoid Intelephense signature confusion.

**Pagination** — `orderBy('created_at', 'desc')->paginate(10)` (not `latest()->paginate()`). Clients navigate via `?page=N`. The `ResourceCollection` wraps paginated results with `links` and `meta` automatically.

**Transactions** — wrap multi-step writes (create + attach relationships + store files) in `DB::transaction()`.

**Authentication flow**:
1. Login/Register → access token (Sanctum, 15 min) returned in body + refresh token set as `HttpOnly` cookie (7 days, stored in `refresh_tokens` table).
2. `POST /refresh` → validates refresh token via `HasAuthToken::verifyToken()`, issues new pair.
3. Email verification uses Laravel signed URLs: `GET /secretary/email-verify/{id}/{hash}`.

## Modules

| Module | Routes prefix | Notes |
|---|---|---|
| Auth | `/admin`, `/secretary` | Sanctum + custom refresh token |
| Professor | `/secretary/professor(s)` | Has many Documents, BelongsToMany Matters |
| Matter | `/matters` | Read-only list |
| Document | `/documents` | Download + delete; nested under Professor for upload |
| DefenseReport | `/secretary/defense-report(s)` | PDF upload, paginated list |
