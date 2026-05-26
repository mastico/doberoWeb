<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

class PageSection extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'subtitle', 'content'];

    protected $fillable = [
        'page',
        'section_key',
        'title',
        'subtitle',
        'content',
        'extra',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function getSection(string $page, string $sectionKey): ?self
    {
        if (! Schema::hasTable('page_sections')) {
            return null;
        }

        $key = "page_section.{$page}.{$sectionKey}";
        $cached = Cache::get($key);

        if ($cached !== null && ! ($cached instanceof static)) {
            Cache::forget($key);
            $cached = null;
        }

        if ($cached !== null) {
            return $cached;
        }

        $value = static::query()
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();

        Cache::forever($key, $value);

        return $value;
    }

    /** Forget the cached value for a specific section. */
    public static function forgetCache(string $page, string $sectionKey): void
    {
        Cache::forget("page_section.{$page}.{$sectionKey}");
    }

    public function extraTrans(string $path, mixed $default = null): mixed
    {
        $value = data_get($this->extra, $path, $default);

        if (! is_array($value)) {
            return $value;
        }

        $available = array_keys(config('locales.available', []));
        $keys = array_keys($value);

        if ($keys === [] || array_diff($keys, $available) !== []) {
            return $value;
        }

        $locale = app()->getLocale();
        $fallback = config('locales.default', 'en');

        return $value[$locale] ?? $value[$fallback] ?? $default;
    }
}
