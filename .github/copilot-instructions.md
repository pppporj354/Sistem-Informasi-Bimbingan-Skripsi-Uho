# Copilot instructions for this repo

This is a Laravel 11 app for managing thesis guidance (Sistem Informasi Bimbingan Skripsi PTIK UNIMA). These notes capture project-specific patterns so agents can work effectively.

## Big picture

-   Roles: admin, HoD, lecturer, student. Authorization uses Gates in `app/Providers/AppServiceProvider.php` and `@can` in views.
-   Core domains: Users, Students, Lecturers, Theses, Guidances, ExamResults. UI uses Blade components with a shared dashboard layout.

## Routing and controllers

-   All web routes are in `routes/web.php` under `Route::middleware('auth')`.
-   Guidance has 3 route groups sharing `GuidanceController` and branching by route name:
    -   `dashboard.bimbingan.*` (all), `dashboard.bimbingan-1.*` (first supervisor), `dashboard.bimbingan-2.*` (second supervisor).
    -   In controller methods, branch with `request()->routeIs('dashboard.bimbingan-1.*'|'dashboard.bimbingan-2.*')` to set `lecturer_id` and choose the view.
-   Exam approvals handled by `ExamResultController`: students create requests; HoD lists/approves in `dashboard/ujian-hasil/*`.

## Data model (UUIDs everywhere)

-   `User hasOne Student|Lecturer|HeadOfDepartement` (role stored on `users.role`).
-   `Student belongsTo User; belongsTo firstSupervisor(lecturer_id_1) & secondSupervisor(lecturer_id_2); hasMany Guidance; hasOne Thesis (convenience)`. Note: multiple Thesis rows may exist; app typically uses the latest by `created_at`.
-   `Guidance belongsTo Student, Lecturer, Thesis; hasOne ExamResult`. Fields: `schedule:datetime`, `guidance_number:uint`, `status_request:enum(pending|approved)`.
-   `Thesis belongsTo Student; hasOne ExamResult; accessor `file_path`returns`/storage/file/skripsi/<file>`.
-   `ExamResult belongsTo Student, Thesis, Guidance; status_request: pending|approved`.

## Conventions and UI

-   Validation via FormRequests in `app/Http/Requests/*`. Keep Indonesian field names: `judul-skripsi`, `topik`, `jadwal` (HTML5 datetime-local `Y-m-dTH:i` and must be > 12 hours from now), `file-skripsi`, `catatan`.
-   File uploads: thesis files go to `storage/app/public/file/skripsi/`; link with `php artisan storage:link`; access via `Thesis::file_path`.
-   Helpers in `app/Helpers/helpers.php` for formatting/generating NIP/NIDN/NIM; exposed via model accessors (`formattedNIM`, `formattedNIP`, `formattedNIDN`).
-   Layout: use `<x-dashboard-layout title="...">` with optional `header` slot. Sidebar/nav adapts by role (`resources/views/components/sidebar.blade.php`).
-   Tables: assign id `table` or `table-2` to auto-init DataTables via `layouts/dashboard.blade.php`.
-   Role string `HoD` is case-sensitive; match exactly in Gates and checks.

## Build, run, and data

-   Requirements: PHP 8.2+, Composer, Node (Vite 5). DB file exists at `database/database.sqlite`.
-   Composer autoload includes `app/Helpers/helpers.php`.
-   Useful commands: install deps, migrate, seed, serve, Vite dev, and link storage.
    -   composer install; php artisan key:generate; php artisan migrate; php artisan db:seed
    -   php artisan serve; npm run dev; php artisan storage:link
-   Seeder (`database/seeders/DatabaseSeeder.php`) needs env vars: `ADMIN_NAME, ADMIN_USERNAME, ADMIN_EMAIL, ADMIN_PASSWORD`.
-   Clockwork is installed (`itsgoingd/clockwork`) for profiling; enable browser extension to inspect requests.

## Gotchas

-   Controller logic depends on route names; ensure links/forms use the correct `dashboard.bimbingan-1.*` or `-2.*` names.
-   Always gate controller actions with the correct role (`Gate::allows('admin'|'HoD'|'lecturer'|'student')`).
-   UUIDs: set foreign UUIDs explicitly when creating related models manually.
-   Asset base URL is computed in `layouts/dashboard.blade.php` from `config('app.url')` and request scheme—set `APP_URL` properly in `.env`.

## Key files/dirs

Routes `routes/web.php`; Controllers `app/Http/Controllers/*`; Models `app/Models/*`; Requests `app/Http/Requests/*`; Views `resources/views/**` (layout at `resources/views/layouts/dashboard.blade.php`, components in `resources/views/components/*`); Migrations/Seeders in `database/*`.

## Example patterns

-   Branch per supervisor route to choose `lecturer_id` and target views.
-   Creating Guidance increments `guidance_number`; if thesis title changes, create a new Thesis and reuse latest otherwise.

## Responses

-   Always provide what file code directory you are working in.
-   Include any relevant context or information that may help in understanding the code.
-   Dont add unnecessary features or code where it doesn't need to be.
