# AGENTS.md — certificados2025

Laravel 11 app: course enrollment, attendance tracking, and certificate generation.

## Quick start

```bash
cp .env.example .env  # edit DB_* and APP_*
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Auth & roles

<spatie_permission>
- **`spatie/laravel-permission` v6** installed. User model uses `HasRoles` trait.
- Two-layer auth: `users.role` (legacy string) + Spatie roles.
- **super-admin** role auto-gets all permissions via `PermissionSeeder` / `AdminAssignAllPermissions`.
- Permission generator: `php artisan permission:create-permission-routes` scans all named routes, creates permissions, assigns all to super-admin. Run after adding routes.
- Script: `bash scripts/createPermissions.sh` (routes command + seeder + cache clear).
- Admin UI: Roles CRUD at `/roles`, Permissions CRUD at `/permissions`, user creation at `/users/create`.
</spatie_permission>

- Laravel UI scaffolding (`Auth::routes()`) with Bootstrap 5.3 + AdminLTE 3.
- Route group `middleware('auth')` wraps all app routes.
- Default creds: `ntm.seduc@gmail.com` / `secret` (admin), `formador@gmail.com` / `senhaformador` (formador).

## Domain models

| Model | Table | Key relations |
|---|---|---|
| `Curso` | `cursos` | hasMany `Encontro` |
| `Encontro` | `encontros` | belongsTo `Curso`, hasMany `Frequencia` |
| `Inscricao` | `inscricoes` | belongsTo `Curso`, belongsTo `User` |
| `Frequencia` | `frequencias` | belongsTo `Encontro`, belongsTo `User` |
| `Certificado` | `certificados` | belongsTo `Curso`, belongsTo `User` |
| `User` | `users` | fields: `name`, `email`, `password`, `role`, `escola` |

## Key dependencies

- **PDF**: `barryvdh/laravel-dompdf` — views in `resources/views/certificados/`, `resources/views/frequencias/`, `resources/views/relatorios/`
- **Frontend**: Vite (`laravel-vite-plugin`) with Bootstrap 5.3 + AdminLTE 3 + Tailwind CSS + Sass
- **Database**: MySQL in local `.env`; SQLite is the `.env.example` default. Tests have DB config commented out in `phpunit.xml`
- **Queue**: `database` driver
- **Cache**: `database` driver
- **Session**: `file` driver

## Dev server

```bash
composer dev
```

Runs concurrently: `php artisan serve`, `php artisan queue:listen --tries=1`, `php artisan pail --timeout=0`, `npm run dev` (Vite).

## Theme

Custom modern theme in `public/css/app-theme.css` — sidebar dark slate, soft cards, larger tables, indigo accent.

## Testing

```bash
php artisan test          # PHPUnit via artisan
./vendor/bin/phpunit      # or direct
```

Two suites: `tests/Unit` and `tests/Feature`. No test DB configured — phpunit.xml has DB overrides commented out. Add `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` for test isolation.

## Linting

```bash
./vendor/bin/pint
```

## Deploy

- `deploy.sh`: `git pull && composer install --no-dev && php artisan migrate --force && php artisan config:cache`
- `atualizar.sh`: interactive commit/merge/push, optionally SSH-deploys to production on main branch.

## Config quirks

- Timezone: `America/Sao_Paulo`, locale: `pt_BR`
- APP_KEY already generated in `.env`
- `storage/fonts/` used by DOMPDF — must be writable