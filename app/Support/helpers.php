<?php

use App\Models\Page;
use Illuminate\Support\Facades\Schema;

if (! function_exists('available_locales')) {
    /**
     * Map of locale code => config array, e.g. ['en' => ['name' => 'English', ...], ...].
     */
    function available_locales(): array
    {
        return config('locales.available', []);
    }
}

if (! function_exists('default_locale')) {
    function default_locale(): string
    {
        return config('locales.default', 'en');
    }
}

if (! function_exists('localize_url')) {
    /**
     * Convert a URL stored in the DB (likely in the default/English locale) to
     * the equivalent URL for the current locale, by matching it against named routes.
     */
    function localize_url(string $url): string
    {
        $locale  = app()->getLocale();
        $default = default_locale();

        if ($locale === $default) {
            return $url;
        }

        $urlPath = rtrim(parse_url($url, PHP_URL_PATH) ?? $url, '/');

        // Temporarily switch to default locale to generate English paths for comparison
        app()->setLocale($default);

        $matched = null;
        foreach (app('router')->getRoutes() as $route) {
            $name = $route->getName();
            if (! $name || str_contains($name, '.') || count($route->parameterNames()) > 0) {
                continue;
            }
            try {
                $generated = rtrim(parse_url(route($name), PHP_URL_PATH) ?? '', '/');
                if ($generated === $urlPath) {
                    $matched = $name;
                    break;
                }
            } catch (\Throwable) {}
        }

        app()->setLocale($locale);

        return $matched ? locale_route($matched) : $url;
    }
}

if (! function_exists('locale_route')) {
    /**
     * Generate a URL for a named route using the current locale prefix.
     * Equivalent to route('hu.about') when locale is 'hu', route('about') when 'en'.
     */
    function locale_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $locale = app()->getLocale();
        $default = default_locale();
        $prefixed = $locale === $default ? $name : $locale.'.'.$name;

        if (app('router')->getRoutes()->hasNamedRoute($prefixed)) {
            return route($prefixed, $parameters, $absolute);
        }

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('image_url')) {
    /**
     * Resolve a stored image path to a public URL.
     * - Absolute HTTP(S) URLs are returned as-is.
     * - Paths starting with /images/ are served from public/ directly.
     * - Everything else is an uploaded file in storage (Storage::url).
     */
    function image_url(?string $path, string $fallback = '/images/defaults/property-placeholder.jpg'): string
    {
        $path = $path ?: $fallback;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, '/images/')) {
            return $path;
        }
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (! function_exists('switch_locale_url')) {
    /**
     * Take the current request URL and return the equivalent URL under a
     * different locale prefix. English (default) is unprefixed.
     */
    function switch_locale_url(string $targetLocale): string
    {
        $available = array_keys(available_locales());
        $default = default_locale();

        if (! in_array($targetLocale, $available, true)) {
            $targetLocale = $default;
        }

        $request = request();
        $route = $request->route();

        if ($route?->getName()) {
            $name = $route->getName();

            foreach ($available as $locale) {
                if (str_starts_with($name, $locale.'.')) {
                    $name = substr($name, strlen($locale) + 1);
                    break;
                }
            }

            $parameters = $route->parametersWithoutNulls();
            $query = $request->query();

            if ($name === 'pages.show'
                && isset($parameters['slug'])
                && class_exists(Page::class)
                && Schema::hasTable('pages')) {
                $page = Page::findBySlug((string) $parameters['slug'], app()->getLocale());

                if ($page) {
                    $url = $page->urlFor($targetLocale);

                    if ($query !== []) {
                        $url .= '?'.http_build_query($query);
                    }

                    return $url;
                }
            }

            $targetName = $targetLocale === $default ? $name : $targetLocale.'.'.$name;

            if (app('router')->getRoutes()->hasNamedRoute($targetName)) {
                return app('url')->originalRoute($targetName, array_merge($parameters, $query));
            }
        }

        $path = trim($request->path(), '/');
        $segments = $path === '' ? [] : explode('/', $path);

        if (isset($segments[0]) && in_array($segments[0], $available, true)) {
            array_shift($segments);
        }

        $prefix = $targetLocale === $default ? '' : $targetLocale;
        $rest = implode('/', $segments);

        $path = trim($prefix.'/'.$rest, '/');
        $url = $request->root().($path === '' ? '/' : '/'.$path);

        if ($qs = $request->getQueryString()) {
            $url .= '?'.$qs;
        }

        return $url;
    }
}


if (! function_exists('linkify_locations')) {
    /**
     * Detect Costa Blanca location keywords in HTML and wrap the first occurrence
     * of each with a link to the programmatic property landing page.
     */
    function linkify_locations(string $html, string $locale = 'en', string $type = 'property'): string
    {
        $locations = config('seo.locations', []);
        $default = config('locales.default', 'en');

        foreach ($locations as $keyword => $slug) {
            $routeKey = $locale === $default ? 'property.landing.sale' : "{$locale}.property.landing.sale";

            if (! app('router')->has($routeKey)) {
                continue;
            }

            $url = route($routeKey, ['type' => $type, 'location' => $slug]);
            $link = '<a href="'.e($url).'" class="text-dobero-blue hover:underline">'.e($keyword).'</a>';

            $html = preg_replace(
                '/(?<![>"\'])('.preg_quote($keyword, '/').')(?![^<]*<\/a>)/iu',
                $link,
                $html,
                1
            );
        }

        return $html;
    }
}
