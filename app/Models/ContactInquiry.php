<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInquiry extends Model
{
    protected $fillable = [
        'inquiry_type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'message',
        'property_id',
        'min_price',
        'max_price',
        'bedrooms',
        'bathrooms',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'min_price' => 'decimal:2',
            'max_price' => 'decimal:2',
            'is_read' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
