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

- Laravel UI scaffolding (`Auth::routes()`) with Bootstrap 4.6 views
- Three roles set via `users.role`: `admin` (default seeder), `formador`, `user` (default column value)
- Route group `middleware('auth')` wraps all app routes
- Admin: `ntm.seduc@gmail.com` / `secret`
- Formador: `formador@gmail.com` / `senhaformador`

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
- **Frontend**: Vite (`laravel-vite-plugin`) with Bootstrap 4.6 + Tailwind CSS + Sass
- **Database**: MySQL in local `.env`; SQLite is the `.env.example` default. Tests have DB config commented out in `phpunit.xml`
- **Queue**: `database` driver (used in development via `composer dev`)
- **Cache**: `database` driver
- **Session**: `file` driver (not `database` as `.env.example` suggests)

## Dev server

```bash
composer dev
```

Runs concurrently: `php artisan serve`, `php artisan queue:listen --tries=1`, `php artisan pail --timeout=0`, `npm run dev` (Vite).

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

Laravel Pint is configured via `laravel/pint` in require-dev.

## Deploy

- `deploy.sh`: pulls main, `composer install --no-dev`, `php artisan migrate --force`, `php artisan config:cache`
- `atualizar.sh`: interactive script that commits, merges, pushes, then optionally SSH-deploys to production (skips deploy on non-main branches)

## Config quirks

- Timezone: `America/Sao_Paulo`, locale: `pt_BR`
- APP_KEY already generated in `.env` (not `.env.example`)
- `storage/fonts/` used by DOMPDF for font cache — must be writable