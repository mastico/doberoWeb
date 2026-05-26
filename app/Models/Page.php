<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public array $translatable = ['slug', 'title', 'body', 'meta_title', 'meta_description'];

    protected $fillable = [
        'key',
        'slug',
        'title',
        'body',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
        'deletable',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'deletable' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public static function findBySlug(string $slug, ?string $locale = null): ?self
    {
        if (! Schema::hasTable('pages')) {
            return null;
        }

        $locale ??= app()->getLocale();
        $default = config('locales.default', 'en');

        $page = static::query()
            ->where('is_published', true)
            ->whereRaw(sprintf("json_extract(slug, '$.%s') = ?", $locale), [$slug])
            ->first();

        if (! $page && $locale !== $default) {
            $page = static::query()
                ->where('is_published', true)
                ->whereRaw(sprintf("json_extract(slug, '$.%s') = ?", $default), [$slug])
                ->first();
        }

        return $page;
    }

    public function urlFor(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $slug = $this->getTranslation('slug', $locale, true);
        $default = config('locales.default', 'en');
        $prefix = $locale === $default ? '' : "/{$locale}";

        return url("{$prefix}/{$slug}");
    }
}
