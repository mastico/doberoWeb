<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Page;
use App\Models\Property;
use App\Models\Service;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';

    protected $description = 'Generate the multilingual XML sitemap';

    public function handle(): int
    {
        $locales = array_keys(config('locales.available', ['en' => []]));
        $defaultLocale = config('locales.default', 'en');

        $sitemap = Sitemap::create();

        // Static pages
        $staticRoutes = ['home', 'about', 'contact', 'relocation', 'construction', 'specials'];
        foreach ($staticRoutes as $routeName) {
            $url = Url::create(route($routeName))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7);

            foreach ($locales as $locale) {
                $routeKey = $locale === $defaultLocale ? $routeName : "{$locale}.{$routeName}";
                if (app('router')->has($routeKey)) {
                    $url->addAlternate(route($routeKey), $locale);
                }
            }
            $url->addAlternate(route($routeName), 'x-default');
            $sitemap->add($url);
        }

        // Properties
        Property::all()->each(function (Property $property) use ($sitemap, $locales, $defaultLocale) {
            $url = Url::create(route('properties.show', ['id' => $property->id]))
                ->setLastModificationDate($property->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8);

            foreach ($locales as $locale) {
                $routeKey = $locale === $defaultLocale ? 'properties.show' : "{$locale}.properties.show";
                if (app('router')->has($routeKey)) {
                    $url->addAlternate(route($routeKey, ['id' => $property->id]), $locale);
                }
            }

            $sitemap->add($url);
        });

        // Blog posts
        BlogPost::where('is_published', true)->get()->each(function (BlogPost $post) use ($sitemap) {
            if ($post->slug && app('router')->has('blog.show')) {
                $sitemap->add(
                    Url::create(route('blog.show', ['slug' => $post->slug]))
                        ->setLastModificationDate($post->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.6)
                );
            }
        });

        // CMS Pages
        Page::where('is_published', true)->get()->each(function (Page $page) use ($sitemap) {
            if ($page->slug && app('router')->has('pages.show')) {
                $sitemap->add(
                    Url::create(route('pages.show', ['slug' => $page->slug]))
                        ->setLastModificationDate($page->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.5)
                );
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at: '.public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}
