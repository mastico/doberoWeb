# Multilingual CMS Rewrite — Phase 2–4 Plan

> Continuation plan for the Dobero multilingual / admin-driven CMS rewrite.
> Phase 1 (i18n foundation) is **complete**. This document describes Phases 2–4.
>
> Background context lives in `~/.claude/projects/-home-mastico-projects-doberoWebsite/memory/project_i18n_architecture.md` — read that first if you're picking this up cold. Design system conventions are in `project_design_system.md`.

---

## 0. Phase 1 recap (what's already in place)

| Concern | How it works today |
|---|---|
| Locales | `config/locales.php` — `en` default, `es` and `hu` available. |
| Routing | Dual-registered groups in `routes/web.php`: English routes named canonically (`home`, `about`, …), Spanish/Hungarian routes registered under `Route::prefix('es')->name('es.')` and the same for `hu`. **Do not** try to use `Route::prefix('{locale?}')` — Laravel can't match unprefixed routes with a constrained optional placeholder, and `URL::defaults` leaks empty values as `?locale=` query strings. |
| URL generation | `App\Providers\AppServiceProvider::boot()` rebinds the `url` container to an anonymous `UrlGenerator` subclass. `route('home')` automatically resolves to `es.home` / `hu.home` when `app()->getLocale()` is not the default. Existing call sites need no changes. |
| Static UI strings | `lang/{en,es,hu}.json` flat key files, accessed via `__('...')`. User specifically chose this format so the files can be machine-translated (e.g. dropped into Google Translate / DeepL). |
| Locale detection | `app/Http/Middleware/SetLocale.php` reads `$request->segment(1)`. Registered as route middleware on both groups. |
| Locale switching UI | `switch_locale_url($code)` helper in `app/Support/helpers.php` (composer files autoload). Language picker is in `resources/views/components/nav.blade.php` (desktop dropdown right of nav + mobile chip strip in the drawer). |
| Positional `route()` args | **Avoid them.** They worked under the old single-locale routing but break in mixed contexts. Always use `route('properties.show', ['slug' => $slug])`. Already fixed in featured-grid, properties-listing, property-detail, specials views. Grep for any remaining `route('xxx', $x)` (without an array) before shipping new code. |

### Known carry-over issues to address as you go
- `database/seeders/PageSectionSeeder.php` seeds CTA URLs like `/about`, `/contact` as raw strings inside `extra` JSON. These render as-is regardless of locale. Phase 2 should convert these to `route_name` keys instead of URLs, then render via `route(...)`. Or make them translatable JSON.
- `resources/views/partials/home/pillars.blade.php` is currently `@include`d **twice** — once in `homepage.blade.php:3` and once inside `hero.blade.php:35`. Remove one (probably the homepage.blade.php one, since the user's intentional edit put it inside the hero).
- `resources/views/components/nav.blade.php` still contains a hardcoded `$primary` array. Phase 3 replaces it.
- Static page Blades (`resources/views/pages/{about,contact,relocation,construction,specials}.blade.php`) still exist. Phase 4 migrates them.

---

## Phase 2 — Make existing content translatable

**Outcome:** Every editor-controlled string (page sections, site settings, catalog models) stores per-locale variants. Admin gets locale tabs on every editor form. Public site picks the right variant for `app()->getLocale()` with fallback to default.

### 2.1 Install spatie/laravel-translatable

```bash
composer require spatie/laravel-translatable
```

No config publish needed by default. The package's `HasTranslations` trait reads from JSON-cast columns where each value is a `{"en": "...", "es": "...", "hu": "..."}` map.

### 2.2 Migrate `page_sections` schema

Current columns: `title (string)`, `subtitle (string)`, `content (text)`, `extra (json)`.

Write a new migration that:
1. Converts `title`, `subtitle`, `content` to JSON columns (use `text` cast as JSON since SQLite — the production env may move to MySQL, see `.env` comment).
2. Backfills existing values: each old string `"foo"` becomes `{"en": "foo"}`.
3. Leaves `extra` as JSON but expects nested translatable shapes (see below).

```php
// up()
Schema::table('page_sections', function (Blueprint $t) {
    $t->json('title_tmp')->nullable();
    $t->json('subtitle_tmp')->nullable();
    $t->json('content_tmp')->nullable();
});

DB::table('page_sections')->orderBy('id')->each(function ($row) {
    DB::table('page_sections')->where('id', $row->id)->update([
        'title_tmp'    => json_encode($row->title ? ['en' => $row->title] : null),
        'subtitle_tmp' => json_encode($row->subtitle ? ['en' => $row->subtitle] : null),
        'content_tmp'  => json_encode($row->content ? ['en' => $row->content] : null),
    ]);
});

Schema::table('page_sections', function (Blueprint $t) {
    $t->dropColumn(['title', 'subtitle', 'content']);
});
Schema::table('page_sections', function (Blueprint $t) {
    $t->renameColumn('title_tmp', 'title');
    $t->renameColumn('subtitle_tmp', 'subtitle');
    $t->renameColumn('content_tmp', 'content');
});
```

For SQLite, `renameColumn` requires `doctrine/dbal`. If that's missing, do the longer dance: add new cols, copy, drop old, recreate with right names.

### 2.3 Update `PageSection` model

```php
use Spatie\Translatable\HasTranslations;

class PageSection extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'subtitle', 'content'];

    // 'extra' is also translatable but per-leaf — see helper below
    protected $casts = [
        'extra'     => 'array',
        'is_active' => 'boolean',
    ];

    public static function getSection(string $page, string $key): ?self
    {
        if (! Schema::hasTable('page_sections')) return null;
        return static::where('page', $page)->where('section_key', $key)->where('is_active', true)->first();
    }
}
```

`extra` handling: define a helper on the model like `extraTrans($path, $default = null)` that reads `data_get($this->extra, $path)` and, if the result is an array shaped like `{"en": "...", "es": "..."}`, returns the current-locale value. Otherwise returns the raw value. This lets us mix translatable and non-translatable keys inside `extra` without restructuring everything at once.

```php
public function extraTrans(string $path, mixed $default = null): mixed
{
    $value = data_get($this->extra, $path, $default);
    if (is_array($value) && array_keys($value) === array_intersect(array_keys($value), array_keys(config('locales.available')))) {
        return $value[app()->getLocale()] ?? $value[config('locales.default')] ?? $default;
    }
    return $value;
}
```

### 2.4 Migrate `site_settings` schema + model

`value` becomes JSON. Add a boolean `is_translatable` column — phone numbers and emails are single-value, body copy is per-locale. Admin UI branches on this flag.

```php
// migration
Schema::table('site_settings', function (Blueprint $t) {
    $t->boolean('is_translatable')->default(false)->after('value');
});
// then convert value column same way as page_sections
```

Seed the existing keys with sensible `is_translatable` flags:
- Translatable: `tagline`, `footer_blurb`, `contact_blurb`, anything that's prose
- Non-translatable: `phone`, `email`, `address`, `instagram_url`, `facebook_url`, etc.

```php
class SiteSetting extends Model
{
    use HasTranslations;
    public array $translatable = ['value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::where('key', $key)->first();
        if (! $row) return $default;
        return $row->is_translatable ? $row->getTranslation('value', app()->getLocale(), true) : $row->value;
    }
}
```

(For non-translatable rows, `value` is still JSON-cast — store as `{"_": "actual-value"}` or just a raw scalar JSON. Simplest: always JSON, accessor returns the bare value for non-translatable.)

### 2.5 Update the seeders

`PageSectionSeeder.php` and `SiteSettingSeeder.php` need to write the new JSON shape. Convert every existing string seed to `['en' => '...', 'es' => '...', 'hu' => '...']`. For initial values, ES/HU can fall back to English — editors fill them in later. Mark `is_translatable` on each SiteSetting.

Convert CTA URLs in `PageSectionSeeder.php` `extra` arrays from raw `/about` strings to `route_name` keys:
```php
'primary_cta'   => ['label' => ['en' => 'Explore Properties', 'es' => 'Explorar', 'hu' => 'Böngészés'], 'route' => 'properties.index'],
'secondary_cta' => ['label' => ['en' => 'Talk To Our Team',   'es' => '...',      'hu' => '...'],      'route' => 'contact'],
```
Then in partials, render via `route($cta['route'])` so URLs auto-localize via the URL macro from Phase 1.

### 2.6 Admin: locale tabs on PageSectionsEditor + SiteSettingsEditor

The two existing Livewire components live in `app/Livewire/Admin/PageSectionsEditor.php` and `SiteSettingsEditor.php` with Blade views in `resources/views/livewire/admin/`.

Recommended UX: a tab strip at the top of each form (EN / ES / HU). The `$form` state holds a per-locale shape:

```php
public array $form = [
    'title'    => ['en' => '', 'es' => '', 'hu' => ''],
    'subtitle' => ['en' => '', 'es' => '', 'hu' => ''],
    'content'  => ['en' => '', 'es' => '', 'hu' => ''],
];
public string $activeLocale = 'en';
```

In the Blade, render inputs bound to `wire:model="form.title.{{ $activeLocale }}"`. The locale tab buttons toggle `$activeLocale` via `wire:click`. On save:

```php
$section->setTranslations('title', $this->form['title']);
$section->setTranslations('subtitle', $this->form['subtitle']);
$section->setTranslations('content', $this->form['content']);
$section->save();
```

For `SiteSettingsEditor`, branch on `$setting->is_translatable`: render a single input vs 3 locale-tabbed inputs.

### 2.7 Update homepage partials to read translatable fields

The `Homepage` Livewire component already calls `PageSection::getSection(...)`. Partials access `$section->title`, `$section->subtitle`, `$section->content`. Spatie's trait auto-resolves these to `app()->getLocale()`, so no view changes needed once the model has the trait.

For `extra` JSON, replace `data_get($section->extra, 'path')` with `$section->extraTrans('path')` wherever the value is user-editable copy.

### 2.8 Catalog models (Property, BlogPost, Service, TeamMember, Testimonial)

Same pattern: migration to convert string/text columns to JSON, add `HasTranslations`, declare `$translatable`. Translatable fields per model:

- `Property`: `title`, `description`, `address` (probably translatable for city/region names — confirm), `features` (JSON array — already array, may need nested translation)
- `BlogPost`: `title`, `excerpt`, `body`, `slug` (translatable slug — see Phase 4 for routing implications)
- `Service`: `name`, `description`
- `TeamMember`: `bio`, `role`
- `Testimonial`: `quote`, `author_title`

Update factories and seeders.

Update admin forms (PropertyForm, BlogPostForm, ServiceForm, TeamMemberForm, TestimonialForm) with the same locale-tab UX.

### 2.9 Property slug — special case

`Property.slug` is auto-generated from title on save in the model. With translatable titles, decide:
- Option A: keep slug single-value (auto-generated from the English title). Property detail URL `/properties/sea-view-villa` is the same regardless of locale, only `/es/` vs `/hu/` prefix changes. Simpler.
- Option B: translatable slug. URLs become `/es/propiedades/villa-vista-al-mar`. Requires resolving by translated slug per locale + admin UI to override slugs per locale.

Recommend **A** for Phase 2, defer B to Phase 4 when we tackle translatable URLs comprehensively.

### 2.10 Phase 2 acceptance checks

- Migrate DB fresh, seed, browse `/`, `/es`, `/hu` — homepage renders with translated section copy.
- Edit a section in `/admin/page-sections`, switch locale tab, save — only the active locale value changes.
- Edit a phone number setting — single field, no locale tab visible.
- Edit the footer blurb setting — three locale tabs visible.
- Property listing page renders translated title/description on `/es/properties`.

---

## Phase 3 — Navigation builder

**Outcome:** The hardcoded `$primary` array in `nav.blade.php` is gone. Editors manage nav from `/admin/navigation` — add/edit/delete items, reorder via up/down arrows, set per-locale labels, set per-locale URLs.

User chose: **free URL only** (no FK to Pages). Each NavItem has a translatable `url` JSON.

User chose: **up/down arrow reordering** for v1 (no drag/drop).

### 3.1 Migration

```php
Schema::create('nav_items', function (Blueprint $t) {
    $t->id();
    $t->foreignId('parent_id')->nullable()->constrained('nav_items')->cascadeOnDelete();
    $t->json('label');          // translatable
    $t->json('url');            // translatable (per-locale URL string)
    $t->unsignedInteger('sort_order')->default(0);
    $t->boolean('is_active')->default(true);
    $t->boolean('opens_in_new_tab')->default(false);
    $t->string('location')->default('primary'); // 'primary' | 'footer' | 'utility' — extensible
    $t->timestamps();
});
```

### 3.2 Model

```php
class NavItem extends Model
{
    use HasTranslations;
    public array $translatable = ['label', 'url'];

    protected $casts = [
        'is_active'        => 'boolean',
        'opens_in_new_tab' => 'boolean',
    ];

    public function children() {
        return $this->hasMany(NavItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeRoots($q) { return $q->whereNull('parent_id'); }
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order'); }
    public function scopeLocation($q, string $loc) { return $q->where('location', $loc); }
}
```

### 3.3 Seeder

Mirror the current hardcoded `$primary` array in `nav.blade.php`. For each item, populate `label` with translations and `url` with translations (English URLs use canonical paths; ES/HU use prefixed paths until Phase 4 introduces translatable route slugs).

### 3.4 Replace hardcoded array in `nav.blade.php`

```php
@php
    $primary = \App\Models\NavItem::roots()->location('primary')->active()->ordered()->with([
        'children' => fn ($q) => $q->active()->ordered(),
    ])->get();
@endphp
```

Then update the loop to `$item->label` and `$item->url` (translatable accessors).

### 3.5 Admin: `/admin/navigation`

New Livewire components:
- `App\Livewire\Admin\NavBuilder` — list view at `/admin/navigation`. Shows root items as cards; each card lists children below. Each row has Edit / Delete / ↑ / ↓ / Toggle Active controls.
- `App\Livewire\Admin\NavItemForm` — create/edit form at `/admin/navigation/create` and `/admin/navigation/{item}/edit`. Fields: parent (dropdown), location, label (3 locale tabs), url (3 locale tabs), opens_in_new_tab, is_active. Use the same locale-tab UX from Phase 2.

Up/down: swap `sort_order` with sibling at adjacent position. Wire into Livewire methods `moveUp($id)` / `moveDown($id)`.

Register the routes in the admin group in `routes/web.php`.

Add a "Navigation" link to the admin sidebar (`resources/views/components/layouts/admin.blade.php`).

### 3.6 Phase 3 acceptance checks

- Visit `/admin/navigation` — see seeded nav tree.
- Edit "About Us" item, change Hungarian label to "Rólunk Új" — verify on `/hu` the nav shows the new label.
- Add a new top-level nav item — verify it appears in the public nav.
- Reorder with up/down — verify order persists and renders in new order.
- Delete a child item — verify it disappears from nav.

---

## Phase 4 — Page builder + dynamic routes + translatable URLs

**Outcome:** Static page Blades are gone. Admin manages all content pages (about, contact, relocation, construction, specials, plus any new pages) from `/admin/pages`. Each page has a translatable rich-text body and a translatable slug — `/about` (en), `/es/sobre-nosotros` (es), `/hu/rolunk` (hu) all resolve to the same Page row.

### 4.1 Migration

```php
Schema::create('pages', function (Blueprint $t) {
    $t->id();
    $t->string('key')->unique();                 // stable internal identifier, e.g. 'about'. Not user-facing.
    $t->json('slug');                            // translatable; resolved per locale
    $t->json('title');                           // translatable
    $t->json('body');                            // translatable rich-text HTML
    $t->json('meta_title')->nullable();          // translatable
    $t->json('meta_description')->nullable();    // translatable
    $t->boolean('is_published')->default(false);
    $t->timestamp('published_at')->nullable();
    $t->boolean('deletable')->default(true);     // false for seeded core pages — admin can edit but not delete
    $t->unsignedInteger('sort_order')->default(0);
    $t->timestamps();
});
```

`key` is the stable identifier — used to link nav items, internal `route_alias`, etc. Slugs change per locale and over time; keys don't.

Add a unique index on `(key)` and ideally a generated index on `slug->>'en'` for fast lookup (DB-specific; skip for SQLite).

### 4.2 Model

```php
class Page extends Model
{
    use HasTranslations;
    public array $translatable = ['slug', 'title', 'body', 'meta_title', 'meta_description'];

    protected $casts = [
        'is_published' => 'boolean',
        'deletable'    => 'boolean',
        'published_at' => 'datetime',
    ];

    public static function findBySlug(string $slug, ?string $locale = null): ?self
    {
        $locale ??= app()->getLocale();
        // Try the requested locale first; fall back to default-locale slug for backwards compat.
        return static::query()
            ->where('is_published', true)
            ->where(function ($q) use ($slug, $locale) {
                $q->whereJsonContains("slug->{$locale}", $slug)
                  ->orWhere("slug->{$locale}", $slug);
            })
            ->first()
            ?? static::query()
            ->where('is_published', true)
            ->where("slug->" . config('locales.default'), $slug)
            ->first();
    }

    public function urlFor(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $slug    = $this->getTranslation('slug', $locale, true);
        $prefix  = $locale === config('locales.default') ? '' : "/$locale";
        return url("{$prefix}/{$slug}");
    }
}
```

### 4.3 Controller + catch-all route

`App\Http\Controllers\PageController@show`:

```php
public function show(Request $request, string $slug)
{
    $page = Page::findBySlug($slug);
    abort_unless($page, 404);

    // If the page's slug for the current locale differs from the requested slug,
    // redirect to the canonical one (e.g. user hit /es/about, redirect to /es/sobre-nosotros).
    $canonical = $page->getTranslation('slug', app()->getLocale(), true);
    if ($canonical !== $slug) {
        return redirect()->route('pages.show', ['slug' => $canonical], 301);
    }

    return view('pages.dynamic', ['page' => $page]);
}
```

Register the route as the LAST route in each locale group in `routes/web.php`:

```php
$localizedRoutes = function () {
    // ...existing routes (homepage, properties, etc.)...
    Route::get('{slug}', [PageController::class, 'show'])->name('pages.show')->where('slug', '[a-z0-9\-]+');
};
```

The regex constraint prevents the catch-all from eating `/properties/foo` (multi-segment paths) — only single-segment slugs hit it.

### 4.4 Dynamic view

`resources/views/pages/dynamic.blade.php` is a thin wrapper around the editorial layout:

```blade
<x-layouts.app :title="$page->meta_title ?: $page->title" :description="$page->meta_description">
    <article class="houzez-container py-20">
        <h1 class="display-md mb-10">{{ $page->title }}</h1>
        <div class="prose prose-editorial max-w-none">
            {!! $page->body !!}
        </div>
    </article>
</x-layouts.app>
```

Add a `.prose-editorial` Tailwind component style in `app.css` if it doesn't already exist (Manrope body, Fraunces headings inside the prose).

### 4.5 Migrate the static page Blades into seeded Page rows

For each of `about, contact, relocation, construction, specials`:
1. Open the Blade, copy the inner HTML (everything inside `<x-layouts.app>`).
2. Convert to plain HTML (replace `{{ route(...) }}` with literal links — the URLs become editable content).
3. Use it as the `body.en` seed value in a new `PageSeeder`.
4. For ES and HU, copy the EN body verbatim — editors translate later.
5. Set `deletable = false` for these 5 core pages.

Translate `slug` per locale: `{"en": "about", "es": "sobre-nosotros", "hu": "rolunk"}`, etc.

After seeding works, **delete the Blade files** in `resources/views/pages/{about,construction,relocation,specials}.blade.php`. Keep `contact.blade.php` for now — it has a form.

### 4.6 The `/contact` special case

Contact has a form, not just content. Approach: keep the route definition for `contact` as today (Livewire/closure route), but change the closure to load the Page row and pass it to a contact-specific Blade that renders the rich-text body above the form:

```php
Route::get('contact', function () {
    $page = \App\Models\Page::where('key', 'contact')->where('is_published', true)->firstOrFail();
    return view('pages.contact', compact('page'));
})->name('contact');
```

`resources/views/pages/contact.blade.php` becomes:

```blade
<x-layouts.app>
    <article class="houzez-container py-20">
        <h1 class="display-md mb-10">{{ $page->title }}</h1>
        <div class="prose prose-editorial">{!! $page->body !!}</div>
        @include('partials.contact-form')
    </article>
</x-layouts.app>
```

The form (`@include('partials.contact-form')`) still POSTs to `route('contact.store')` which is unchanged.

### 4.7 Translatable URLs for fixed routes (`/properties`, `/contact`)

User wants URL segments themselves to be translated — `/propiedades`, `/ingatlanok` instead of `/es/properties`, `/hu/properties`.

User chose **hand-rolled with phrases JSON**: build a route translation map.

Add `lang/{es,hu}/routes.php` (PHP files, not JSON, since they're not user-facing strings):

```php
// lang/es/routes.php
return [
    'properties' => 'propiedades',
    'contact'    => 'contacto',
    'about'      => 'sobre-nosotros',
    'relocation' => 'mudanza',
    'construction' => 'construccion',
    'specials'   => 'especiales',
];
```

In `routes/web.php`, the non-default-locale registration uses these translated segments:

```php
foreach (array_keys(config('locales.available')) as $code) {
    if ($code === config('locales.default')) continue;
    $translations = require lang_path("$code/routes.php");

    Route::prefix($code)
        ->name("$code.")
        ->middleware(SetLocale::class)
        ->group(function () use ($translations) {
            Route::get('/', Homepage::class)->name('home');
            Route::get($translations['about'] ?? 'about', fn () => view('pages.about'))->name('about');
            Route::get($translations['properties'] ?? 'properties', PropertiesListing::class)->name('properties.index');
            // ...etc, one per route...
        });
}
```

Refactor: the `$localizedRoutes` closure from Phase 1 takes a `$translations` array param. Use `$translations['key'] ?? 'key'` for each path segment.

For Pages (catch-all route), the slug IS the translation — no separate map needed.

### 4.8 Admin: `/admin/pages`

- `App\Livewire\Admin\PagesIndex` — list at `/admin/pages`. Columns: Title (default locale), Key, Slug (default locale), Published toggle, Updated at. Search by title.
- `App\Livewire\Admin\PageForm` — create/edit at `/admin/pages/create` and `/admin/pages/{page}/edit`. Fields:
  - Key (slug-cased identifier, immutable after create, hidden for deletable=false pages)
  - Locale tabs for: title, slug, body (rich-text), meta_title, meta_description
  - Published toggle + published_at
  - Sort order

Use **TinyMCE Community self-hosted** for the body editor. Steps:
1. `npm install tinymce` — or download community release into `public/vendor/tinymce/`.
2. Add a Blade component `<x-tinymce wire:model="form.body.en" />` that initializes TinyMCE on the textarea and pushes `change` events to Livewire.
3. Configure TinyMCE toolbar: bold, italic, underline, headings, lists, link, image, table, code view. Disable the API key prompt (set `tinymce.init({ promotion: false, branding: false })`).
4. Image uploads route to a Livewire upload handler that stores under `storage/app/public/pages/`.

The locale tab strip re-initialises TinyMCE per locale (or you can render 3 textareas, one per locale, and toggle visibility).

Add a "Pages" link to the admin sidebar.

### 4.9 Update NavItem URLs

After Page slugs become translatable, NavItem URLs that point at internal pages must use the localized slug too. Since user chose **free URL only** for nav items (no FK to Page), the admin is responsible for keeping nav URLs in sync. Document this in the admin UI with a small helper: when adding a nav item, show a "Pick a page" dropdown that auto-fills the per-locale URLs from the selected page's slugs. The dropdown does NOT create a hard FK — it just pre-fills the inputs.

### 4.10 Phase 4 acceptance checks

- Visit `/about`, `/es/sobre-nosotros`, `/hu/rolunk` — same Page row renders with translated body.
- Visit `/es/about` — 301 redirect to `/es/sobre-nosotros`.
- Visit `/es/contact` — works (still uses contact route + form).
- Visit `/es/propiedades` — works (translated URL segment).
- Create a new page in admin called "Mortgage Guide" with key=`mortgage-guide`, publish it — visit `/mortgage-guide`, `/es/<es-slug>`, `/hu/<hu-slug>`.
- Unpublish a page — visiting it 404s.
- Try to delete a core page (deletable=false) — admin blocks it.
- Add a nav item pointing to the new page — verify nav reflects per-locale URLs.

---

## Cross-cutting concerns / nice-to-haves

These don't fit cleanly inside one phase but should be considered:

### Locale fallback in views
When a translation is missing, spatie's `HasTranslations` returns `null` by default. Configure it to fall back to the default locale via `config('translatable.fallback_locale', 'en')` (publish the package config: `php artisan vendor:publish --tag=translatable`). Set `fallback_any = true` so unset locales fall back gracefully.

### SEO
- Add `<link rel="alternate" hreflang="es" href="..." />` tags to every page's `<head>`, listing the three locales.
- The default app layout (`resources/views/components/layouts/app.blade.php`) needs to receive the current Page (Phase 4) or PageSection collection (Phase 2) and emit hreflang tags.

### Sitemap
Generate `/sitemap.xml` listing all published pages × all locales. Use `spatie/laravel-sitemap` or hand-roll a controller. Defer until Phase 4 is done.

### Tests
For each phase add Feature tests:
- Phase 2: `tests/Feature/TranslatableContentTest.php` — fresh seed, hit `/es`, assert Spanish strings; edit via Livewire test of `PageSectionsEditor`, assert per-locale persistence.
- Phase 3: `tests/Feature/NavigationTest.php` — seed NavItems, hit `/`, assert nav structure; edit via `NavBuilder`, assert reorder works.
- Phase 4: `tests/Feature/PagesTest.php` — seed Pages, hit `/about` / `/es/sobre-nosotros`, assert content; create + publish via `PageForm`, assert dynamic route resolves.

### Code style
Run `./vendor/bin/pint` after each phase. Project uses Laravel Pint default rules.

### Migration ordering
Each phase is one or more migrations. Name them with timestamps so they run in order. Do NOT combine phases into a single migration — keep them split so partial rollouts work.

---

## Suggested commit / branch structure

One branch per phase, merged sequentially:
- `feat/i18n-translatable-content` (Phase 2)
- `feat/admin-navigation-builder` (Phase 3)
- `feat/admin-page-builder` (Phase 4)

Each branch should be reviewable in ~1 day of work. Phase 4 is the biggest; if it grows, split into 4a (Page model + dynamic routes, no translatable URLs) and 4b (translatable URL segments + slug-based redirects).

---

## Phase 5 — Property Import Integration

> Enable doberoWebsite to receive property data written directly by doberoImport (and future import sources).  
> This phase is a schema + model extension only — no admin UI changes are required beyond ensuring existing property admin works with the new fields.

---

### 5.1 Goals

1. Store all Solvia fields that were previously only available in WordPress post-meta.
2. Track which source each property came from and when it was last seen.
3. Support future sources (e.g. Idealista) with source-specific metadata via a flexible `extra_data` JSON column.
4. Invalidate stale properties: when a full sync no longer includes a property, set `status = 'sold'` and ensure it sorts to the bottom of listings.

---

### 5.2 New columns — `properties` table migration

Write a migration `2026_XX_XX_add_import_fields_to_properties_table.php`:

| Column | Type | Notes |
|---|---|---|
| `source` | `string` | e.g. `'solvia'`, `'idealista'` — which importer created this row |
| `external_id` | `string` | importer-assigned key, e.g. `property-12345` |
| `province` | `string, nullable` | Spanish provincia / region (Solvia field) |
| `living_area` | `decimal(8,2), default 0` | Usable/living m² (Solvia `m2`) — distinct from `sqm` (total) |
| `original_price` | `decimal(12,2), nullable` | Pre-discount price (Solvia `primerPrecioPublicacion`) |
| `latitude` | `decimal(10,7), nullable` | GPS latitude |
| `longitude` | `decimal(10,7), nullable` | GPS longitude |
| `extra_data` | `json, nullable` | Source-specific fields that have no common column |
| `source_synced_at` | `timestamp, nullable` | When importer last included this property in a sync |

Add a unique index on `(source, external_id)` so `updateOrCreate` is idempotent.

Also add `'sold'` status if not already present in the `status` enum (check existing migration; the original enum includes `sold` so this may already be covered).

---

### 5.3 Update `Property` model

- Add all new columns to `$fillable`.
- Add casts: `original_price => decimal:2`, `living_area => decimal:2`, `latitude => decimal:7`, `longitude => decimal:7`, `extra_data => array`, `source_synced_at => datetime`.
- Add scope `scopeSold` returning records where `status = 'sold'`.
- Update `scopeForSale` / `scopeForRent` to exclude `sold` records (if not already excluding).
- Add scope `scopeOrderByStatus` that sorts `sold` last: `orderByRaw("CASE WHEN status = 'sold' THEN 1 ELSE 0 END ASC")`.

---

### 5.4 Listing page sort order

Update the property listing query (wherever `Property::query()` is built for the public listing page) to chain `->scopeOrderByStatus()` or the raw `orderByRaw` expression so sold listings always appear at the bottom.

---

### 5.5 Translation cache sharing

doberoImport's `translation_cache` table lives in its own app database. doberoWebsite should add a second DB connection (`importer`) in `config/database.php` pointing to the same MySQL database as doberoImport. The `TranslationCacheService` in doberoImport already reads/writes this table, so no changes are needed there — doberoWebsite simply does not duplicate translations.

---

### 5.6 Testing

- Migration rolls up and down cleanly.
- `Property::updateOrCreate(['source' => 'solvia', 'external_id' => 'property-1'], [...])` creates and then updates without duplicating.
- Sold properties appear last on the listing page.

---

### Commit / branch

Branch: `feat/property-import-schema`

