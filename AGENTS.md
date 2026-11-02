# AGENTS.md

"Barokah Mart" POS (point-of-sale) practicum app. Laravel 13 + PHP ^8.3 (local PHP 8.5), Blade + Tailwind 4 + Vite 8, Sanctum for the `api` guard. All UI copy is Indonesian.

## Commands

- `composer dev` — runs `php artisan dev`, which starts `artisan serve`, `queue:listen`, `pail` logs, and `npm run dev` together (Windows uses `concurrently`). Prefer this over starting servers individually.
- `composer test` — clears config, then `php artisan test`.
- Single test: `php artisan test --filter=ExampleTest` or `php artisan test tests/Feature/ExampleTest.php`.
- Frontend only: `npm run dev` / `npm run build`.
- Format PHP: `php vendor/bin/pint` (no `pint.json`; defaults).
- Full first-time setup: `composer setup`.

## Testing quirk

`laravel/pao` wraps PHPUnit when an agent is detected, so `php artisan test` prints a single JSON line (e.g. `{"tool":"phpunit","result":"passed",...}`) instead of normal PHPUnit output. Tests run on SQLite `:memory:` per `phpunit.xml` and need no external services.

## Environment / database

- `.env` points at **MySQL** (`DB_CONNECTION=mysql`, database `pos_toko`); `.env.example` and `config/database.php` default to SQLite. Don't assume SQLite for local dev — only tests use it.
- `php artisan migrate --seed` seeds `admin@barokahmart.com` and `kasir@barokahmart.com`, both password `password`.

## Architecture

- Authorization is role-based: `users.role` enum (`admin` | `kasir`), enforced by the `role:` middleware alias registered in `bootstrap/app.php` (`App\Http\Middleware\CheckRole`). `role:admin`: categories, products, users, reports/sales. `role:admin,kasir`: pos and `/index`.
- `CheckRole` renders the `auth.error` view on failure instead of aborting with 403.
- API routes in `routes/api.php` sit behind `auth:sanctum`.
- Tailwind 4 is CSS-first (`resources/css/app.css` via `@tailwindcss/vite`); there is no `tailwind.config.js`.

## Current state

Student project, but the app runs: `php artisan route:list` resolves all 37 routes and `composer test` passes. Controllers present: `CategoryController`, `ProductController`, `UserController`, `ReportController`, `PosController`, `Auth\LoginController`, `DashboardController`. Views live under `master-data/{category,product,user}`, `pos`, `report`, `posts`.

Conventions worth preserving:

- Write forms use the `FormRequest` classes in `app/Http/Requests` (not the `Request::validate()` macro), and `authorize()` checks `role === 'admin'`.
- Every model field written by a form must be in `$fillable` (`Product` needs `unit` + `stock`; `User` needs `role`). `AppServiceProvider` calls `Model::preventSilentlyDiscardingAttributes()` outside production, so a missing field now throws instead of being silently dropped.
- `ProductController::index` reads `search` / `category_id` query params; the view passes `$categories` for the filter dropdown.

Known gaps: `PosController` has no product-image upload despite the `products.image` column; `resources/views/master-data/category/index.blade.php` styling may lag behind the product views.

