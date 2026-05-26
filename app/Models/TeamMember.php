<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class TeamMember extends Model
{
    use HasTranslations;

    public array $translatable = ['role', 'bio'];

    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('homepage.agents'));
        static::deleted(fn () => Cache::forget('homepage.agents'));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
