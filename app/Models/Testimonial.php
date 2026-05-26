<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasTranslations;

    public array $translatable = ['content', 'author_role'];

    protected $fillable = [
        'content',
        'author_name',
        'author_role',
        'author_company',
        'author_photo',
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
        static::saved(fn () => Cache::forget('homepage.testimonials'));
        static::deleted(fn () => Cache::forget('homepage.testimonials'));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('author_name');
    }
}
