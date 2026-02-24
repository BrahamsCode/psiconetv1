# CLAUDE.md — Psiconet v1

## Project Overview

**Psiconet** is a psychological clinic management system (sistema de gestión de consultorio psicológico). It manages patient records (consultantes), therapy sessions (intervenciones), and comprehensive psychological histories (historias psicológicas) including substance use, problem behaviors, evaluations, and psychiatric referrals.

The entire domain is in **Spanish** — models, field names, routes, views, flash messages, and comments all use Spanish terminology.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.2+ |
| Framework | Laravel 12 |
| Database | SQLite (development & testing) |
| Frontend templating | Blade + custom CSS (inline in layout) |
| Asset pipeline | Vite 7 + Tailwind CSS 4 |
| Testing | Pest 3 (PHPUnit) |
| Code style | Laravel Pint |
| Dev tooling | Laravel Sail, Laravel Pail, Laravel Boost |

---

## Development Commands

```bash
# Full initial setup (install deps, generate key, migrate, build assets)
composer setup

# Start all dev servers (PHP + queue worker + Vite HMR) concurrently
composer dev

# Run tests
composer test
# or directly:
php artisan test

# Code style (Laravel Pint)
./vendor/bin/pint

# Database
php artisan migrate
php artisan migrate:fresh --seed

# Asset compilation
npm run dev      # development with HMR
npm run build    # production build
```

---

## Directory Structure

```
psiconetv1/
├── app/
│   ├── Http/Controllers/
│   │   ├── ConsultanteController.php          # CRUD for patient records
│   │   ├── DashboardController.php            # Dashboard stats
│   │   ├── EvaluacionPsicologicaController.php # Psychological evaluations
│   │   ├── HistoriaPsicologicaController.php  # Clinical history (complex, uses DB transactions)
│   │   ├── InterconsultaPsiquiatricaController.php # Psychiatric referrals
│   │   └── IntervencionController.php         # Therapy sessions
│   ├── Models/
│   │   ├── ConductaProblema.php               # Problem behaviors (ordered, has JSON baseline data)
│   │   ├── Consultante.php                    # Core patient model
│   │   ├── ConsumoSustancia.php               # Substance use records
│   │   ├── EvaluacionPsicologica.php          # Psych evaluations with estado attribute
│   │   ├── HistoriaPsicologica.php            # Clinical history (central record)
│   │   ├── InterconsultaPsiquiatrica.php      # Psychiatric referral requests
│   │   ├── Intervencion.php                   # Individual therapy sessions
│   │   ├── TratamientoPrevio.php              # Previous treatment history
│   │   └── User.php                           # Standard Laravel user (auth not yet implemented)
│   └── Providers/AppServiceProvider.php
├── database/
│   ├── migrations/                            # 10 migrations, see schema section below
│   ├── factories/UserFactory.php
│   └── seeders/DatabaseSeeder.php
├── resources/
│   ├── css/app.css                            # Tailwind CSS entry point
│   ├── js/app.js                              # JS entry point (axios bootstrap)
│   └── views/
│       ├── layouts/app.blade.php              # Main layout (CSS is inline here, not in app.css)
│       ├── dashboard.blade.php
│       ├── consultantes/                      # index, create, show, edit
│       └── intervenciones/                    # create, edit
├── routes/
│   ├── web.php                                # All web routes
│   └── console.php                            # Artisan schedule
└── tests/
    ├── Feature/ExampleTest.php
    ├── Unit/ExampleTest.php
    └── Pest.php
```

---

## Database Schema

### Core Table: `consultantes`
Primary patient record. Has two sets of fields:

**Basic fields** (original migration):
`nombre`, `edad`, `telefono`, `email`, `observaciones`, `fecha_registro`

**Filiación fields** (added via `add_filiacion_fields_to_consultantes` migration):
`genero`, `grado_instruccion`, `estado_civil`, `ocupacion`, `residencia`, `religion`, `natural_de`, `tiempo_residencia_lima`, `persona_responsable`, `responsable_parentesco`, `responsable_telefono`, `asisten_primera_consulta`, `lugar_entrevista`, `terapeuta_asignado`, `recomendado_por`, `recomendado_detalle`

> **Note**: `ConsultanteController` currently only validates/saves the basic fields. The filiación fields exist in the model's `$fillable` but are not yet wired up in the create/edit forms.

### `intervenciones`
Therapy session records. Fields: `consultante_id` (FK), `numero_sesion`, `fecha`, `asistidos`, `actividades`, `terapeuta`

### `historias_psicologicas`
One-to-one with `consultantes`. Fields include `numero_historia` (auto-generated as `YYYY-NNNN`), `fecha_historia`, `motivo_consulta`, `problema_actual_1..5`, `diagrama_familiar_observaciones`, `lazos_familiares` (JSON).

### `conductas_problema`
Ordered problem behaviors linked to `historias_psicologicas`. Fields: `numero_orden`, `conducta_problema`, `objetivo_terapeutico`, `procedimiento`, `linea_base` (JSON for weekly tracking data).

### `consumo_sustancias`
Substance use records linked to `historias_psicologicas`.

### `tratamientos_previos`
Prior treatment history linked to `historias_psicologicas`.

### `evaluaciones_psicologicas`
Psychological test records. Fields: `test_psicologico`, `fecha_programada`, `fecha_ejecutada`, `evaluador`, `observacion`, `resultados`, `archivo_resultado`. Has a computed `estado` attribute (Pendiente / Vencida / Ejecutada).

### `interconsultas_psiquiatricas`
Psychiatric referral records linked to `historias_psicologicas`.

---

## Route Structure

```
GET  /                                              → dashboard
GET  /consultantes                                  → consultantes.index
GET  /consultantes/create                           → consultantes.create
POST /consultantes                                  → consultantes.store
GET  /consultantes/{consultante}                    → consultantes.show
GET  /consultantes/{consultante}/edit               → consultantes.edit
PUT  /consultantes/{consultante}                    → consultantes.update
DEL  /consultantes/{consultante}                    → consultantes.destroy

GET  /consultantes/{consultante}/intervenciones/create  → intervenciones.create
POST /consultantes/{consultante}/intervenciones         → intervenciones.store
GET  /intervenciones/{intervencion}/edit                → intervenciones.edit
PUT  /intervenciones/{intervencion}                     → intervenciones.update
DEL  /intervenciones/{intervencion}                     → intervenciones.destroy

GET  /consultantes/{consultante}/historia/create    → historias.create
POST /consultantes/{consultante}/historia           → historias.store
GET  /historias/{historia}                          → historias.show
GET  /historias/{historia}/edit                     → historias.edit
PUT  /historias/{historia}                          → historias.update
GET  /historias/{historia}/pdf                      → historias.pdf  (stub — not implemented)

POST /historias/{historia}/evaluaciones             → evaluaciones.store
PUT  /evaluaciones/{evaluacion}                     → evaluaciones.update
DEL  /evaluaciones/{evaluacion}                     → evaluaciones.destroy

POST /historias/{historia}/interconsultas           → interconsultas.store
PUT  /interconsultas/{interconsulta}                → interconsultas.update
DEL  /interconsultas/{interconsulta}                → interconsultas.destroy
```

All routes use **route model binding**. No authentication middleware is applied to any route (no login system yet).

---

## Model Relationships

```
Consultante
  ├── hasMany   → Intervencion
  └── hasOne    → HistoriaPsicologica
                     ├── hasMany → ConsumoSustancia
                     ├── hasMany → TratamientoPrevio
                     ├── hasMany → ConductaProblema  (ordered by numero_orden)
                     ├── hasMany → EvaluacionPsicologica
                     └── hasMany → InterconsultaPsiquiatrica
```

All foreign key relationships use `onDelete('cascade')`.

---

## Key Conventions

### Controllers
- Use **route model binding** (type-hint models in method signatures).
- Redirect back to `show` or `index` after mutations with a `session('success')` flash.
- Use `DB::beginTransaction()` / `DB::commit()` / `DB::rollBack()` for operations that touch multiple tables (e.g., `HistoriaPsicologicaController@store`).
- Related collections (consumo_sustancias, tratamientos_previos, conductas_problema) are **delete-and-recreate** on update — no partial updates.

### Models
- Always declare `$fillable` explicitly (no mass-assignment via `$guarded = []`).
- Use `$casts` for date fields and JSON columns.
- Business logic lives in the model when appropriate (e.g., `HistoriaPsicologica::generarNumeroHistoria()`, `EvaluacionPsicologica::getEstadoAttribute()`).
- Spanish method and property names for domain concepts (e.g., `tieneHistoria()`, `historiaPsicologica()`).

### Views / Blade
- Extend `layouts.app` and use `@section('title')`, `@section('page-title')`, `@section('content')`.
- Flash messages are handled automatically in the layout for `success`, `error`, `info`, `warning`.
- CSS component classes defined in `resources/views/layouts/app.blade.php` (inline `<style>` block):
  - `.btn`, `.btn-primary`, `.btn-secondary`, `.btn-danger`, `.btn-success`, `.btn-sm`
  - `.card`, `.card-header`
  - `.form-group`
  - `.badge`, `.badge-primary`, `.badge-secondary`, `.badge-success`, `.badge-warning`
  - `.stats-grid`, `.stat-card`
  - `.alert`, `.alert-success`, `.alert-error`, `.alert-info`, `.alert-warning`
  - `.actions` (flex row for action buttons)
- Corporate color palette via CSS custom properties:
  - `--primary: #53BAAE` (teal)
  - `--secondary: #1A4E73` (dark blue)
- Sidebar uses emoji icons for nav items.
- All user-facing text is in **Spanish**.

### Testing
- Framework: **Pest 3** (functional syntax).
- Tests use **in-memory SQLite** (`DB_DATABASE=:memory:` via phpunit.xml).
- Feature tests cover HTTP responses; Unit tests cover isolated logic.
- Test files use Pest's closure syntax: `test('description', function () { ... })`.

---

## Environment Configuration

Key `.env` settings:

```ini
DB_CONNECTION=sqlite          # Uses database/database.sqlite (not in VCS)
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

For testing, `phpunit.xml` overrides to use in-memory SQLite. No other external services are required for local development.

---

## Known Incomplete Features / Stubs

1. **PDF export** — `HistoriaPsicologicaController@exportarPdf` renders a view stub at `historias.pdf` but has no PDF library integrated. A comment suggests DomPDF or mPDF.
2. **Authentication** — No auth system is implemented. `User` model and users table exist but no login/registration routes.
3. **Filiación fields in forms** — The `add_filiacion_fields_to_consultantes` migration extended the `consultantes` table, but `ConsultanteController` validation and Blade forms only handle the original basic fields.
4. **Historias views for edit/show** — The `HistoriaPsicologicaController` references `historias.create`, `historias.show`, `historias.edit`, and `historias.pdf` views, but these view files are not present in `resources/views/historias/`. They need to be created.
5. **Sidebar placeholder links** — The "Historias Clínicas", "Información Relacionada al Consumo", and "Diagrama Familiar" sidebar sections all point to `consultantes.index` as placeholders.

---

## Adding New Features — Checklist

When adding a new entity/module:

1. Create migration in `database/migrations/`
2. Create model in `app/Models/` with `$fillable`, `$casts`, and relationships
3. Create controller in `app/Http/Controllers/` using route model binding
4. Add routes to `routes/web.php`
5. Create Blade views extending `layouts.app`
6. Add navigation links to `resources/views/layouts/app.blade.php` sidebar
7. Write Feature tests in `tests/Feature/`
