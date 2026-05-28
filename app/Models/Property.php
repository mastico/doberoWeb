<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Property extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'description', 'meta_title', 'meta_description'];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'address',
        'city',
        'state_country',
        'postal_code',
        'price',
        'original_price',
        'currency',
        'property_type',
        'status',
        'bedrooms',
        'bathrooms',
        'sqm',
        'living_area',
        'images',
        'is_featured',
        'property_id_ref',
        'source',
        'external_id',
        'province',
        'latitude',
        'longitude',
        'extra_data',
        'source_synced_at',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'extra_data' => 'array',
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'sqm' => 'decimal:2',
            'living_area' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
            'source_synced_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $property): void {
            if (blank($property->slug)) {
                $title = $property->getTranslation('title', config('locales.default', 'en'), true);
                $parts = array_filter([
                    $title,
                    $property->property_type,
                    $property->city,
                ]);
                $property->slug = Str::slug(implode(' ', $parts));
            }
        });
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PropertyReview::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(ContactInquiry::class);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeForSale(Builder $query): Builder
    {
        return $query->where('status', 'for_sale');
    }

    public function scopeForRent(Builder $query): Builder
    {
        return $query->where('status', 'for_rent');
    }

    public function scopeSold(Builder $query): Builder
    {
        return $query->where('status', 'sold');
    }

    /** Always sort sold/rented properties to the bottom of any result set. */
    public function scopeOrderByStatus(Builder $query): Builder
    {
        return $query->orderByRaw("CASE WHEN status IN ('sold', 'rented') THEN 1 ELSE 0 END ASC");
    }
}
