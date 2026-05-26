# Copilot Instructions

## Project: DOBERO HOME CREATOR

Spanish real estate website (multilingual: EN / ES / HU). Public-facing pages plus an admin backend for content management.

## Stack

- **Backend**: Laravel 13.x on PHP 8.3+
- **Frontend**: Livewire 3 + Blade + Alpine.js + Tailwind CSS 3 (Vite 8)
- **Database**: SQLite by default (`database/database.sqlite`); MySQL config is available but commented out in `.env`
- **Auth scaffold**: Laravel Jetstream (Livewire stack, Teams enabled)

## Commands

```bash
# First-time setup (install + key:generate + migrate + build)
composer setup

# Local dev — runs php artisan serve, queue listener, pail logger, and Vite concurrently
composer dev

# Database
php artisan migrate
php artisan migrate:fresh --seed   # wipe + reseed page sections, properties, etc.
php artisan storage:link           # required for admin image uploads to be served

# Testing (PHPUnit; uses in-memory SQLite via phpunit.xml)
composer test                                  # clears config cache then full suite
php artisan test --filter TestClassName        # single test class
php artisan test --filter test_method_name     # single test method

# Code style (Laravel Pint)
./vendor/bin/pint
./vendor/bin/pint --test   # check-only / dry-run
```

## Architecture

### Routing (`routes/web.php`)

All public routes are wrapped in a `SetLocale` middleware group and defined once as `$localizedRoutes`, then registered twice: unprefixed for the default locale (English) and prefixed for non-default locales (`/es/…`, `/hu/…`). Non-default locale route names are namespaced: `es.about`, `hu.contact`, etc.

Full-page Livewire components are routed directly — no controllers except for one:

| Path | Handler |
|---|---|
| `/` | `App\Livewire\Homepage` |
| `/properties` | `App\Livewire\PropertiesListing` |
| `/properties/{slug}` | `App\Livewire\PropertyDetail` |
| `/about`, `/contact`, `/relocation`, `/construction`, `/specials` | Static Blade in `resources/views/pages/` |
| `POST /contact` | `ContactController@store` (the only controller) |
| `/admin/*` | `App\Livewire\Admin\*` behind `['auth', 'verified']` |

### Internationalisation

- Three locales: `en` (default, unprefixed), `es`, `hu` — defined in `config/locales.php`.
- `App\Http\Middleware\SetLocale` reads the first URL segment and calls `app()->setLocale(...)`.
- Translation strings live in `lang/en.json`, `lang/es.json`, `lang/hu.json` — use `__('key')` in Blade.
- `app/Support/helpers.php` (autoloaded) provides `available_locales()`, `default_locale()`, and `switch_locale_url(string $locale)` for building locale-switcher links without hardcoding URLs.

### Content model

Homepage and About page content is **not hardcoded** — it lives in two tables:

- **`page_sections`** (`page` + `section_key` + `title`/`subtitle`/`content`/`extra` JSON).  
  Fetch via `PageSection::getSection('home', 'hero')`.  
  Homepage section keys: `hero`, `mission`, `expertise`, `services_banner`, `investment`, `contact`, `featured_grid`, `agents`, `testimonials`, `partners`.  
  About section keys: `header`, `intro`, `team`, `services`, `blog`, `testimonials`.
- **`site_settings`** (key/value). Access via `SiteSetting::get('key', 'default')` / `SiteSetting::set('key', 'value')`.

Admin edits these via the `PageSectionsEditor` and `SiteSettingsEditor` Livewire components (`/admin/page-sections`, `/admin/settings`).

### Defensive `Schema::hasTable()` pattern

`Homepage::render()` wraps every model query with `Schema::hasTable(...)` and returns an empty collection on failure. This ensures the homepage renders on fresh clones before migrations have run. **Preserve this pattern** whenever adding new data sources to `Homepage`.

### Key models (`app/Models/`)

- `Property` — slug auto-generated from title on save; `images` cast to `array`; scopes `featured()`, `forSale()`, `forRent()`; `hasMany` reviews + inquiries.
- `PageSection` / `SiteSetting` — see content model above; both gate DB reads on `Schema::hasTable`.
- `TeamMember`, `Testimonial`, `Service`, `BlogPost` — all carry `is_active` + `sort_order` and expose `active()` + `ordered()` scopes.
- `ContactInquiry` — contact form submissions, optionally linked to a property.
- `PropertyReview` — `is_approved` gate; surfaced via `Property::approvedReviews()`.

### View layout

- **Public**: `resources/views/components/layouts/app.blade.php`
- **Admin**: `resources/views/components/layouts/admin.blade.php` (sidebar)
- Homepage (`resources/views/livewire/homepage.blade.php`) composes section partials from `resources/views/partials/home/` — one file per section key.
- Do **not** edit Jetstream's published views by hand — republish with `php artisan vendor:publish --tag=jetstream-views`.

### Custom Tailwind palette (`tailwind.config.js`)

```js
navy:   { DEFAULT: '#1a3151', dark: '#111e30', light: '#2a4a7a' }
dobero: { blue: '#1a7ebf', accent: '#2a6496' }
```

Use `bg-navy`, `text-dobero-blue`, etc.

## Key Conventions

### Livewire 3
- Public properties for `wire:model` binding.
- Validate via `$this->validate()` (rules array or `rules()` method); use `wire:model.live` sparingly.
- Listen with `#[On('event-name')]`; dispatch with `$this->dispatch('event-name', data: ...)`.
- Mark derived/cached properties with `#[Computed]`.
- Lazy-load expensive components: `<livewire:component lazy />` + implement `placeholder()`.

### Blade
- Prefer `<x-component />` over `@include`. Reusable UI in `resources/views/components/`.
- Homepage sections are partials in `resources/views/partials/home/`.

### Eloquent
- Declare all relationships on the model; use scopes for reusable filters.
- Cast JSON columns (`images`, `extra`) to `array` in `$casts`.
- Avoid raw `DB::` unless performance-critical.

### Jetstream / Fortify
- Post-login `HOME` redirects to `/admin` — see `config/fortify.php`.
- Teams enabled; `$user->currentTeam` is available.

### Testing
- Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`.
- Use `Livewire::test(MyComponent::class)` for component tests.
- Use `RefreshDatabase` when hitting the database; `phpunit.xml` forces SQLite `:memory:`.
