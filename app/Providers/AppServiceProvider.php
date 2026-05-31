<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Block migrate:fresh / migrate:refresh / db:wipe when connected to production MySQL.
        DB::prohibitDestructiveCommands(
            str_contains(config('database.connections.mysql.host', ''), 'digitalocean.com')
        );

        $this->resolveLocalizedRouteNames();
    }

    /**
     * When the current locale isn't the default, rewrite calls like
     * `route('home')` to the corresponding `{locale}.home` registration
     * defined in routes/web.php. Keeps existing call sites untouched.
     */
    protected function resolveLocalizedRouteNames(): void
    {
        UrlGenerator::macro('originalRoute', function ($name, $parameters = [], $absolute = true) {
            return $this->toRoute($this->routes->getByName($name), $parameters, $absolute);
        });

        $original = UrlGenerator::class;
        $this->app->extend('url', function ($url, $app) {
            return new class($app['router']->getRoutes(), $app['request'], $app['config']->get('app.asset_url')) extends UrlGenerator
            {
                public function route($name, $parameters = [], $absolute = true)
                {
                    $locale = app()->getLocale();
                    $default = config('locales.default');

                    if ($locale !== $default && ! str_starts_with($name, "{$locale}.")) {
                        $candidate = "{$locale}.{$name}";
                        if ($this->routes->hasNamedRoute($candidate)) {
                            $name = $candidate;
                        }
                    }

                    return parent::route($name, $parameters, $absolute);
                }
            };
        });
    }
}
