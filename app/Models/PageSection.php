<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

        return static::query()
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();
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
