# DOBERO HOME CREATOR

> **Multilingual real estate website** for the Costa Blanca, Spain.  
> Built with Laravel 13 + Livewire 3 + Tailwind CSS — English, Spanish, Hungarian.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack](#2-tech-stack)
3. [Quick Start](#3-quick-start)
4. [Project Structure](#4-project-structure)
5. [Routing & Localisation](#5-routing--localisation)
6. [Database & Models](#6-database--models)
7. [Public Pages](#7-public-pages)
8. [Admin Panel](#8-admin-panel)
9. [Translation System](#9-translation-system)
10. [Image Handling](#10-image-handling)
11. [Frontend Architecture](#11-frontend-architecture)
12. [Testing](#12-testing)
13. [Caching](#13-caching)
14. [Deployment & Restore](#14-deployment--restore)

---

## 1. Project Overview

DOBERO HOME CREATOR is a full-stack real estate website serving both public visitors and an authenticated admin team.

**Public features:**
- Homepage with hero, services, featured properties, team agents, testimonials, partners
- Property listing with filtering and search
- Individual property detail pages with image gallery and enquiry form
- About Us page with team, testimonials, partner logos
- Static informational pages: Contact, Relocation, Construction, Specials

**Admin features:**
- CRUD for Properties, Team Members, Testimonials, Services, Blog Posts
- Homepage & About page content editor (via `page_sections` table)
- Site settings editor (footer info, social links, contact details)
- File-backed translation editor — edit all UI strings per page in the browser
- Navigation builder
- Contact inquiry inbox

---

## 2. Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3+ |
| Framework | Laravel 13.x |
| Frontend components | Livewire 3 + Alpine.js |
| CSS | Tailwind CSS 3 (Vite 8) |
| Auth scaffold | Laravel Jetstream (Livewire stack, Teams enabled) |
| Database | SQLite (default) — MySQL config available in `.env` |
| Testing | PHPUnit via `composer test` |
| Code style | Laravel Pint |

**Custom Tailwind colours:**
```js
navy:   { DEFAULT: '#1a3151', dark: '#111e30', light: '#2a4a7a' }
dobero: { blue: '#1a7ebf', accent: '#2a6496' }
```

---

## 3. Quick Start

```bash
# 1. Clone
git clone git@github.com:mastico/doberoWeb.git
cd doberoWeb

# 2. Install + key + migrate + build (one command)
composer setup

# 3. Symlink public storage
php artisan storage:link

# 4. Seed the database (properties, team, testimonials, etc.)
php artisan migrate:fresh --seed

# 5. Start dev server (Laravel + queue + Pail logger + Vite, concurrently)
composer dev
```

> **Restore from SQL dump** (skips seeding, uses exact data from this repo):
> ```bash
> php artisan migrate:fresh
> php artisan tinker --execute="DB::unprepared(file_get_contents(database_path('database.sql')));"
> ```

**Other useful commands:**
```bash
php artisan migrate                          # run new migrations only
php artisan migrate:fresh --seed             # wipe + full reseed
./vendor/bin/pint                            # fix code style
./vendor/bin/pint --test                     # check-only
composer test                                # full PHPUnit suite
php artisan test --filter TestClassName      # single test class
```

---

## 4. Project Structure

```
app/
  Http/
    Controllers/
      ContactController.php        # only controller; handles contact form POST
    Middleware/
      SetLocale.php                # reads URL prefix, sets app locale
  Livewire/
    Homepage.php                   # public homepage component
    PropertiesListing.php          # public properties list + filters
    PropertyDetail.php             # public single-property view
    AboutPage.php                  # public about page
    ContactForm.php                # public contact form
    Admin/
      Dashboard.php
      PropertiesIndex.php / PropertyForm.php
      TeamMembersIndex.php / TeamMemberForm.php
      TestimonialsIndex.php / TestimonialForm.php
      ServicesIndex.php / ServiceForm.php
      BlogPostsIndex.php / BlogPostForm.php
      PageSectionsEditor.php       # homepage & about content
      SiteSettingsEditor.php       # footer/contact/social settings
      TranslationsEditor.php       # file-backed i18n editor
      NavBuilder.php / NavItemForm.php
      PagesIndex.php / PageForm.php
  Models/
    Property.php                   # slug auto-gen, images cast to array
    TeamMember.php                 # translatable role + bio
    Testimonial.php                # translatable content
    Service.php                    # translatable title + description
    BlogPost.php                   # translatable title/excerpt/content
    PageSection.php                # homepage/about section content
    SiteSetting.php                # key-value settings
    ContactInquiry.php             # contact form submissions
    PropertyReview.php             # is_approved gate
    NavItem.php / Page.php         # dynamic navigation & custom pages
  Services/
    TranslationFileManager.php     # reads/writes/caches lang files
  Support/
    helpers.php                    # available_locales(), locale_route(),
                                   # switch_locale_url(), image_url()

config/
  locales.php                      # available: en (default), es, hu
  translation_pages.php            # maps all JSON keys to page groups

database/
  migrations/                      # 25 migrations
  seeders/                         # full seed data with local image paths
  database.sql                     # SQL dump of current data (restore source)

lang/
  en.json / es.json / hu.json      # flat-key JSON translations
  en/ es/ hu/                      # PHP array translations (relocation page)

public/
  images/
    defaults/                      # all default/seed images (no CDN)
      property-*.jpg               # 18 property images (6 x 3 shots)
      team-*.jpg                   # 15 team member photos
      testimonial-*.jpg            # 3 testimonial avatars
      blog-*.jpg / service-*.jpg   # 4 blog + 6 service images
      investment-*.jpg             # 8 investment section images
      services-banner.jpg          # services section background
      avatar-placeholder.jpg       # fallback avatar
      property-placeholder.jpg     # fallback property image

resources/
  views/
    components/layouts/
      app.blade.php                # public layout
      admin.blade.php              # admin layout (sidebar)
    livewire/
      homepage.blade.php           # composes partials/home/*
      properties-listing.blade.php
      property-detail.blade.php
      admin/                       # all admin views
    partials/
      home/                        # one file per homepage section:
        hero, mission, expertise, services-banner, investment,
        agents, testimonials, partners, contact
      about/                       # one file per about section:
        header, intro, team, testimonials, services
    pages/                         # static Blade pages
      about, contact, relocation, construction, specials
```

---

## 5. Routing & Localisation

**Three locales:** `en` (default, unprefixed), `es`, `hu` — defined in `config/locales.php`.

Routes are registered **twice** in `routes/web.php`:
```php
// English (default) — no prefix
Route::get('/', Homepage::class)->name('home');
Route::get('/about', ...)->name('about');

// Spanish and Hungarian — prefixed
Route::prefix('es')->name('es.')->group($localizedRoutes);
Route::prefix('hu')->name('hu.')->group($localizedRoutes);
```

`SetLocale` middleware reads the first URL segment and calls `app()->setLocale()`.

**Helper functions** (`app/Support/helpers.php`):

| Function | Purpose |
|---|---|
| `available_locales()` | Returns `['en' => [...], 'es' => [...], 'hu' => [...]]` |
| `default_locale()` | Returns `'en'` |
| `locale_route($name, $params)` | Generates URL for current locale (auto-prefixes) |
| `switch_locale_url($locale)` | Rewrites current URL to target locale |
| `image_url($path, $fallback)` | Resolves image path to public URL (see section 10) |

**Translation strings:**
- `__('Key')` / `lang/*.json` — flat strings used on all non-relocation pages
- `trans('group.key')` / `lang/en/relocation.php` etc. — nested arrays for the relocation page

---

## 6. Database & Models

### Schema overview

| Table | Purpose |
|---|---|
| `properties` | Property listings; `images` JSON array |
| `team_members` | Staff; translatable `role`, `bio` |
| `testimonials` | Client testimonials; translatable `content`, `author_role` |
| `services` | Service cards; translatable `title`, `description` |
| `blog_posts` | Blog; translatable `title`, `excerpt`, `content` |
| `page_sections` | Homepage + About page content blocks |
| `site_settings` | Key-value global settings |
| `contact_inquiries` | Contact form submissions |
| `property_reviews` | Property reviews with `is_approved` flag |
| `nav_items` | Dynamic navigation builder |
| `pages` | Custom CMS pages with per-locale slugs |
| `users` / `teams` / `*` | Jetstream auth tables |

### Key model conventions

All catalogue models (`TeamMember`, `Testimonial`, `Service`, `BlogPost`) share:
- `HasTranslations` (spatie/laravel-translatable) for multilingual columns
- `is_active` boolean + `sort_order` integer
- `scopeActive()` and `scopeOrdered()` scopes

**Property model extras:**
- Slug auto-generated from title on `saving` event
- `images` cast to `array` (JSON column)
- Scopes: `featured()`, `forSale()`, `sold()`; `scopeOrderByStatus()` pushes sold to bottom
- Relationships: `hasMany` ContactInquiry, `hasMany` PropertyReview

**Property types:** `flat`, `studio`, `house`, `duplex`, `penthouse`, `bungalow`, `other`

**Property statuses:** `for_sale`, `sold` (rental listings not supported)

**Content retrieval:**
```php
// Homepage/About sections
PageSection::getSection('home', 'hero');   // returns section row
PageSection::getSection('about', 'team');

// Global settings
SiteSetting::get('contact_phone', '+34 000 000 000');
SiteSetting::set('contact_email', 'info@dobero.es');
```

**Homepage section keys:** `hero`, `mission`, `expertise`, `services_banner`, `investment`, `contact`, `agents`, `testimonials`, `partners`

**About section keys:** `header`, `intro`, `team`, `services`, `blog`, `testimonials`

### Defensive table checks

`Homepage::render()` wraps every query with `Schema::hasTable()` — the homepage renders even before migrations have run:

```php
if (! Schema::hasTable('properties')) {
    return $this->render(['properties' => collect()]);
}
$properties = Property::featured()->active()->get();
```

**Preserve this pattern** when adding new data sources to `Homepage`.

---

## 7. Public Pages

| URL | Handler | Description |
|---|---|---|
| `/` | `Livewire\Homepage` | Full homepage with all sections |
| `/properties` | `Livewire\PropertiesListing` | Filterable property grid/list (keyword, type, status, city; advanced: min/max price, min bedrooms, min bathrooms, sort, view mode) |
| `/properties/{slug}` | `Livewire\PropertyDetail` | Property detail + gallery + enquiry |
| `/about` | static Blade + Livewire | About us page |
| `/contact` | static Blade + `Livewire\ContactForm` | Contact form (POST to `ContactController`) |
| `/relocation` | static Blade | Relocation guide |
| `/construction` | static Blade | Construction services |
| `/specials` | static Blade | Special offers |

All URLs also available under `/es/` and `/hu/` prefixes.

### Navigation scroll behaviour

The public nav is transparent at the top, becomes `bg-navy` after 50px scroll:
```blade
x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 50"
:class="scrolled ? 'bg-navy shadow-lg' : 'bg-transparent'"
```

---

## 8. Admin Panel

All admin routes are behind `['auth', 'verified']` middleware. Post-login redirect goes to `/admin` (configured in `config/fortify.php`). Teams are enabled — `$user->currentTeam` is available.

| URL | Component | Purpose |
|---|---|---|
| `/admin` | `Dashboard` | Stats overview |
| `/admin/properties` | `PropertiesIndex` / `PropertyForm` | Property CRUD + image upload |
| `/admin/team-members` | `TeamMembersIndex` / `TeamMemberForm` | Team CRUD |
| `/admin/testimonials` | `TestimonialsIndex` / `TestimonialForm` | Testimonials CRUD |
| `/admin/services` | `ServicesIndex` / `ServiceForm` | Services CRUD |
| `/admin/blog-posts` | `BlogPostsIndex` / `BlogPostForm` | Blog CRUD |
| `/admin/page-sections` | `PageSectionsEditor` | Homepage & About content |
| `/admin/settings` | `SiteSettingsEditor` | Global site settings |
| `/admin/translations` | `TranslationsEditor` | All UI translation strings |
| `/admin/nav` | `NavBuilder` | Navigation items |
| `/admin/pages` | `PagesIndex` / `PageForm` | Custom CMS pages |
| `/admin/users` | `UsersIndex` / `UserForm` | Admin user accounts |

### File uploads

Admin image uploads use Livewire's `WithFileUploads`. Files land in `storage/app/public` and are served via the `public/storage` symlink. Run `php artisan storage:link` on every fresh deployment.

### User management (`/admin/users`)

Admins can create, edit, and delete application users:

- **List** (`/admin/users`) — table with name, email, verified status, 2FA, joined date
- **Create** (`/admin/users/create`) — name, email, password (admin-created users are pre-verified)
- **Edit** (`/admin/users/{user}/edit`) — change name, email, or password; if email changes the user must re-verify
- **Delete** — any user except the currently logged-in account (self-delete is forbidden)

---

## 9. Translation System

### Runtime translations

Two patterns coexist:

1. **JSON flat keys** — used on all pages except relocation:
   ```blade
   {{ __('Learn More') }}
   {{ __('Contact Us') }}
   ```
   Files: `lang/en.json`, `lang/es.json`, `lang/hu.json`

2. **PHP array files** — used on the relocation page:
   ```blade
   {{ trans('relocation.hero.title') }}
   ```
   Files: `lang/en/relocation.php`, `lang/es/relocation.php`, `lang/hu/relocation.php`

### Admin translation editor (`/admin/translations`)

All strings are editable in the browser, grouped by page:

| Group | Type | Keys | Content |
|---|---|---|---|
| `global` | JSON | 23 | Nav, footer, common buttons |
| `homepage` | JSON | 34 | Hero, section CTAs |
| `contact` | JSON | 14 | Form labels and messages |
| `specials` | JSON | 46 | Specials page content |
| `construction` | JSON | 34 | Construction page content |
| `relocation` | PHP arrays | 117 | Full relocation guide |

**How it works** (`app/Services/TranslationFileManager.php`):
- Reads from `Cache::rememberForever("translations.{$group}")`
- On save: writes files → `Cache::forget()` → `app('translator')->setLoaded([])` — **live immediately, no server restart**
- Creates datestamped backup before every save: `lang/es.json.2026-05-25_23-24-51.old`
- PHP nested arrays are flattened to dot-notation for display, unflattened on save

**To revert a translation change:**
```bash
cp lang/es.json.2026-05-25_23-24-51.old lang/es.json
php artisan cache:clear
```

---

## 10. Image Handling

### `image_url()` helper

All image rendering uses the `image_url()` helper:

```php
// In Blade:
<img src="{{ image_url($property->images[0]) }}">
<img src="{{ image_url($member->photo, '/images/defaults/avatar-placeholder.jpg') }}">
```

Resolution logic:
- `https://...` or `http://...` → returned as-is
- `/images/...` → returned as-is (served from `public/`)
- Anything else → `Storage::url($path)` (admin-uploaded file in `storage/app/public`)

### Default / seed images

All images are stored locally in `public/images/defaults/` — **zero external CDN dependencies at runtime**:

```
investment-studio/flat/house/duplex/2/3/4.jpg   investment section (8 images)
services-banner.jpg                              services section background
property-1a/b/c … property-6a/b/c.jpg           6 properties x 3 shots = 18 images
blog-1/2/3/4.jpg                                 blog post covers
service-1…6.jpg                                  service card images
team-janos/nydia/jovi/daria/sara/michael/        15 individual team member photos
  jonathan/hector/ricardo/julian/pedro/antonio/
  1/2/3.jpg
testimonial-1/2/3.jpg                            testimonial author photos
avatar-placeholder.jpg                           fallback when no photo set
property-placeholder.jpg                         fallback when no property image set
```

---

## 11. Frontend Architecture

### Livewire 3 conventions

```php
// Public properties for wire:model binding
public string $search = '';
public string $filter = 'all';

// Validation
$this->validate(['email' => 'required|email']);

// Events
#[On('property-saved')]
public function refresh(): void { ... }

$this->dispatch('property-saved', id: $property->id);

// Computed / cached properties
#[Computed]
public function filteredProperties() { ... }

// Lazy-load heavy components
<livewire:properties-listing lazy />
public function placeholder() { return view('livewire.placeholders.listing'); }
```

### Blade conventions

- Prefer `<x-component />` over `@include`
- Reusable UI in `resources/views/components/`
- Homepage sections in `resources/views/partials/home/` — one file per section key
- Admin sidebar layout: `resources/views/components/layouts/admin.blade.php`
- Do not edit Jetstream views directly — republish: `php artisan vendor:publish --tag=jetstream-views`

### Alpine.js

Used for: scroll-aware nav, image gallery lightbox, mobile menu toggle, tab switching, form toggles.

### Vite + Tailwind

```bash
npm run dev      # dev with HMR
npm run build    # production build → public/build/
```

---

## 12. Testing

Tests use PHPUnit with in-memory SQLite (configured in `phpunit.xml` — no separate test database needed).

```bash
composer test                                   # config:clear then full suite
php artisan test --filter TestClassName         # single class
php artisan test --filter test_method_name      # single method
```

- Feature tests: `tests/Feature/`
- Unit tests: `tests/Unit/`
- Use `RefreshDatabase` trait for any test hitting the DB
- Use `Livewire::test(Component::class)` for Livewire component tests

---

## 13. Caching

Cache driver: **`file`** (`storage/framework/cache/`). Set in `.env`:

```env
CACHE_STORE=file
```

The file driver is preferred over `database` to avoid write-amplification on the shared SQLite file. No Redis or Memcached required.

### What is cached

| Data | Cache key | TTL | Invalidated by |
|---|---|---|---|
| `PageSection::getSection()` | `page_section.{page}.{key}` | forever | `PageSectionsEditor::save()` |
| `SiteSetting::get()` | `site_setting.{key}.{locale}` | forever | `SiteSettingsEditor::save()` |
| Homepage aggregates | `homepage.agents/testimonials/services/posts/featured` | forever | Relevant admin Form/Index save & delete |
| `PropertyDetail` per slug | `property.{slug}` | **5 minutes** | `PropertyForm::save()`, `PropertiesIndex::delete()` |
| Translation groups | `translations.{group}` | forever | `TranslationsEditor` → `TranslationFileManager::saveGroup()` |

**`PropertiesListing` is not cached** — user-driven search, filters, and pagination make caching impractical.

### Cache key design notes

- `SiteSetting` cache keys include the locale (`site_setting.{key}.en`) because translatable settings resolve differently per locale.
- `PageSection` models are cached whole (all locales in the JSON column); locale resolution happens at Blade render time via `$section->title`. `getSection()` includes a self-healing guard: if a cached entry is ever an `__PHP_Incomplete_Class` (e.g. after a deploy with stale serialized objects), it is automatically evicted and re-fetched.
- Homepage aggregate caches hold full Eloquent Collections; cleared as a unit when content changes.

### Invalidation helpers

`PageSection::forgetCache(string $page, string $key)` and `SiteSetting::forgetCache(string $key)` are static helpers that centralise the `Cache::forget()` call(s) per model.

### Manual cache clear

```bash
php artisan cache:clear
```

---

## 14. Deployment & Restore

### Fresh server setup

```bash
git clone git@github.com:mastico/doberoWeb.git
cd doberoWeb

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Environment
cp .env.example .env
php artisan key:generate
# Edit .env: APP_URL, DB_* if using MySQL

# Database — option A: exact data from SQL dump
php artisan migrate
php artisan tinker --execute="DB::unprepared(file_get_contents(database_path('database.sql')));"

# Database — option B: fresh seed from seeders
php artisan migrate:fresh --seed

# Storage symlink (required for admin image uploads)
php artisan storage:link

# Production caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Updating an existing deployment

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate
php artisan config:cache && php artisan route:cache && php artisan view:cache
npm ci && npm run build
```

### Key `.env` variables

| Key | Description |
|---|---|
| `APP_NAME` | Application name shown in UI |
| `APP_URL` | Full URL including scheme (e.g. `https://dobero.es`) |
| `APP_LOCALE` | Default locale (`en`) |
| `DB_CONNECTION` | `sqlite` (default) or `mysql` |
| `DB_DATABASE` | Path to sqlite file or MySQL database name |
| `MAIL_*` | Mail driver settings for the contact form |

---

## SEO & AEO (Answer Engine Optimization)

The site includes a comprehensive SEO/AEO implementation covering technical multilingual SEO, schema markup, programmatic landing pages, image optimization, and topical authority.

### Meta Fields

`properties`, `blog_posts`, and `services` tables each have `meta_title` and `meta_description` JSON columns (translatable via `HasTranslations`). Admin forms expose locale-tabbed inputs for all three locales. The layout falls back to `SiteSetting::get('seo_default_description')` if no per-page description is set.

### Technical SEO

- **Canonical URL**: every page emits `<link rel="canonical">`. `PropertyDetail` passes the exact localized property URL; `PropertiesListing` passes the clean base URL (strips query params).
- **Hreflang**: `app.blade.php` emits `<link rel="alternate" hreflang="…">` for all three locales plus `x-default` on every page.
- **Sitemap**: run `php artisan app:generate-sitemap` to produce `public/sitemap.xml`. Scheduled daily via `routes/console.php`. Covers all locales × (properties, blog posts, CMS pages, static routes).

### Schema Markup (JSON-LD)

All JSON-LD is rendered as `<script type="application/ld+json">` in the `<head>`.

| Component | Injected in | Type |
|---|---|---|
| `<x-seo.organization />` | `app.blade.php` (global) | `Organization` + `RealEstateAgent` with `sameAs` (social + GBP) |
| `<x-seo.property-schema :property="$property" />` | `property-detail.blade.php` | `SingleFamilyResidence` + `Offer` + `AggregateRating` (if ≥1 approved review) |
| `<x-seo.faq-schema page="relocation" />` | `relocation.blade.php`, `construction.blade.php` | `FAQPage` (from `faq_items` table) |

### FAQ Admin (`/admin/faqs`)

Fully manageable FAQs per page via `FaqItemsIndex` / `FaqItemForm` Livewire components. Questions and answers are translatable (EN/ES/HU). Assign each item to a `page` key (`relocation`, `construction`, etc.) and it will be automatically included in the FAQPage schema for that page.

### Programmatic Landing Pages

SEO landing pages for property type × location combinations are served at:

```
/properties/{type}-for-sale-in-{location}
```

Examples: `/properties/house-for-sale-in-torrevieja`, `/es/properties/flat-for-sale-in-alicante`

These are handled by `PropertyLandingController` and query properties filtered by type + city. An optional intro paragraph can be added via `PageSectionsEditor` using the key `property_landing.{type}.{location}`.

### Image Optimization

Uploaded property images are automatically optimized on save via `spatie/laravel-image-optimizer`. The optimizer strips EXIF data and compresses JPEG/PNG files. Requires system tools to be installed:

```bash
# Debian/Ubuntu
apt-get install jpegoptim optipng pngquant gifsicle webp
```

If the binaries are not installed, the error is silently caught and the original image is stored unmodified.

### Lazy Loading

All below-fold images (`loading="lazy"`) in: property gallery thumbnails, property listing cards, similar listings, agent photos, testimonial avatars, partner logos.

### Property Slug — City + Type Append

New properties auto-generate slugs as `{title}-{property_type}-{city}` (e.g., `sea-view-villa-villa-javea`). Existing slugs are never overwritten.

### Internal Link Engine

`linkify_locations(string $html, string $locale, string $type)` in `app/Support/helpers.php` detects Costa Blanca location keywords in HTML and wraps the first occurrence of each with a link to the programmatic landing page. Location list is configurable in `config/seo.php`. Apply in blog post detail views.

### Global SEO Settings

Add or update these keys in Site Settings (`/admin/settings`) under the **SEO & AEO** section:

| Key | Description |
|---|---|
| `seo_default_title` | Site-wide fallback page title (translatable) |
| `seo_default_description` | Site-wide fallback meta description (translatable) |
| `gbp_url` | Google Business Profile URL (used in `Organization` schema `sameAs`) |

### Off-Page Checklist (non-code)

- Create a **Google Business Profile** with NAP matching `contact_address`, `contact_phone`, `contact_email` in Site Settings.
- Register on **Páginas Amarillas** (ES), Hungarian expat directories, Costa Blanca forums. Link each to the corresponding locale homepage (e.g., `/hu`, `/es`).
- Blog category taxonomy: use `legal`, `lifestyle`, `market-updates` as `category` values on `blog_posts` for topical authority silos.

---

*Built for DOBERO HOME CREATOR — Costa Blanca, Spain.*
