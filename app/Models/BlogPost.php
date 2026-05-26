<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'excerpt', 'content', 'meta_title', 'meta_description'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author',
        'published_at',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $post): void {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->getTranslation('title', config('locales.default', 'en'), true));
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}
