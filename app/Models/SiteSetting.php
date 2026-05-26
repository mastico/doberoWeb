<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
    use HasTranslations;

    public array $translatable = ['value'];

    protected $fillable = [
        'key',
        'value',
        'type',
        'is_translatable',
    ];

    protected function casts(): array
    {
        return [
            'is_translatable' => 'boolean',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (! Schema::hasTable('site_settings')) {
            return $default;
        }

        $setting = static::query()->where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        if (! Schema::hasColumn('site_settings', 'is_translatable')) {
            return $setting->getRawOriginal('value') ?? $default;
        }

        if ($setting->is_translatable) {
            return $setting->getTranslation('value', app()->getLocale(), true) ?? $default;
        }

        return $setting->getTranslation('value', config('locales.default', 'en'), false) ?? $default;
    }

    public static function set(string $key, mixed $value, string $type = 'text', bool $isTranslatable = false): self
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->type = $type;

        if (! Schema::hasTable('site_settings') || ! Schema::hasColumn('site_settings', 'is_translatable')) {
            $setting->value = is_array($value) ? json_encode($value) : (string) $value;
            $setting->save();

            return $setting;
        }

        $setting->is_translatable = $isTranslatable;
        $locale = $isTranslatable ? app()->getLocale() : config('locales.default', 'en');
        $setting->setTranslation('value', $locale, $value);
        $setting->save();

        return $setting;
    }
}
