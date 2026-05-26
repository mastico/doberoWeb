# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project: DOBERO HOME CREATOR

Spanish real estate website. Public-facing pages (homepage, about, properties listing/detail) plus an admin backend for content management.

## Stack

- Laravel 13.x on PHP 8.3+
- Livewire 3 + Blade + Alpine.js for the frontend
- Tailwind CSS 3 (custom colors below), built with Vite 8
- Laravel Jetstream (Livewire stack, Teams enabled) for auth scaffolding
- SQLite by default (`database/database.sqlite`); MySQL config commented in `.env`

## Commands

```bash
# First-time setup (composer script runs install + key:generate + migrate + build)
composer setup

# Local dev (concurrently runs php serve + queue listener + pail logs + vite)
composer dev

# Individual processes
php artisan serve
npm run dev

# Database
php artisan migrate
php artisan migrate:fresh --seed   # wipe + reseed page sections, properties, etc.
php artisan storage:link           # required: admin uploads write to storage/app/public

# Testing (PHPUnit; in-memory sqlite per phpunit.xml)
composer test                                  # clears config then runs full suite
php artisan test --filter TestClassName        # single class
php artisan test --filter test_method_name     # single method

# Code style (Laravel Pint)
./vendor/bin/pint
./vendor/bin/pint --test           # check-only
```

## Architecture

### Routing (`routes/web.php`)
Full-page Livewire components are routed directly (no controllers):
- `/` → `App\Livewire\Homepage`
- `/properties` → `App\Livewire\PropertiesListing`
- `/properties/{slug}` → `App\Livewire\PropertyDetail`
- `/about`, `/contact`, `/relocation`, `/construction`, `/specials` → static Blade in `resources/views/pages/`
- `/contact` POST → `ContactController@store` (the only controller in the app)
- `/admin/*` → group with `['auth', 'verified']` middleware, all routed to `App\Livewire\Admin\*` components. `/dashboard` redirects to `/admin`.

### Content model — read this before editing pages
Homepage and About page content is **not hardcoded**. It comes from two tables:
- `page_sections` (page + section_key + title/subtitle/content/extra JSON). Fetched via `PageSection::getSection('home', 'hero')`. Homepage section keys: `hero`, `mission`, `expertise`, `services_banner`, `investment`, `contact`, `featured_grid`, `agents`, `testimonials`, `partners`.
- `site_settings` (key/value). Used for footer, contact info, social links via `SiteSetting::get('key', 'default')` / `SiteSetting::set(...)`.

Admin edits these through `PageSectionsEditor` and `SiteSettingsEditor` Livewire components.

### Defensive table checks
`Homepage::render()` guards every model query with `Schema::hasTable(...)` and falls back to an empty collection. This is intentional — the app must render before migrations run (e.g. fresh clones). Preserve this pattern when adding new homepage data sources.

### Key models (`app/Models/`)
- `Property` — slug auto-generated from title on save; `images` cast to array; scopes `featured()`, `forSale()`, `forRent()`; `hasMany` reviews + inquiries.
- `PageSection` / `SiteSetting` — see above; both gate reads on `Schema::hasTable` for safe boot.
- `TeamMember`, `Testimonial`, `Service`, `BlogPost` — all carry `is_active` + `sort_order` and expose `active()` + `ordered()` scopes. Homepage and admin lists rely on these.
- `ContactInquiry` — stores contact form submissions, optionally linked to a property.
- `PropertyReview` — `is_approved` gate; surfaced via `Property::approvedReviews()`.

### View layout
- Public layout: `resources/views/components/layouts/app.blade.php` (referenced as `components.layouts.app`).
- Admin layout: `resources/views/components/layouts/admin.blade.php` (sidebar).
- Homepage view (`resources/views/livewire/homepage.blade.php`) composes partials in `resources/views/partials/home/` — one file per section key.
- Jetstream's own published Blade components live alongside in `resources/views/components/`; don't edit them by hand — republish with `php artisan vendor:publish --tag=jetstream-views`.

### Custom Tailwind palette (`tailwind.config.js`)
```js
navy:   { DEFAULT: '#1a3151', dark: '#111e30', light: '#2a4a7a' }
dobero: { blue: '#1a7ebf', accent: '#2a6496' }
```
Use `bg-navy`, `text-dobero-blue`, etc.

### Navigation scroll behavior
The public nav is transparent at the top and becomes `bg-navy` after scrolling >50px, driven by Alpine:
```blade
x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 50"
:class="scrolled ? 'bg-navy shadow-lg' : 'bg-transparent'"
```

### File uploads
Admin image uploads use Livewire's `WithFileUploads` and land in `storage/app/public`. The `storage:link` symlink is required for them to be served.

## Conventions

- **Livewire 3**: public properties for `wire:model`, validate via `$this->validate()`, listen with the `#[On('event-name')]` attribute, dispatch with `$this->dispatch(...)`, mark derived properties with `#[Computed]`. Prefer `lazy` + `placeholder()` for heavy components. Use `wire:model.live` sparingly.
- **Blade**: prefer `<x-component />` over `@include`. Reusable UI lives in `resources/views/components/`.
- **Eloquent**: declare all relationships on the model; use scopes for reusable query filters; cast JSON columns to `array`. Avoid raw `DB::` unless performance demands it.
- **Jetstream/Fortify**: post-login `HOME` is `/admin` (see `config/fortify.php`). Teams are enabled — `$user->currentTeam` is available.
- **Tests**: Feature tests in `tests/Feature/`, unit in `tests/Unit/`. Use `Livewire::test(Component::class)` for Livewire components and `RefreshDatabase` when hitting the DB. phpunit.xml forces sqlite `:memory:` for the test run.
