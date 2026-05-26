@props(['property'])
@php
use Illuminate\Support\Facades\Schema;

$locale = app()->getLocale();
$title = is_array($property->title) ? ($property->title[$locale] ?? $property->title['en'] ?? '') : $property->title;
$description = is_array($property->description) ? ($property->description[$locale] ?? $property->description['en'] ?? '') : $property->description;
$firstImage = ! empty($property->images) ? image_url($property->images[0]) : null;

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'SingleFamilyResidence',
    'name' => $title,
    'description' => strip_tags((string) $description),
    'url' => route('properties.show', ['slug' => $property->slug]),
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $property->city ?? 'Costa Blanca',
        'addressCountry' => 'ES',
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => $property->price,
        'priceCurrency' => 'EUR',
        'availability' => in_array($property->status, ['for_sale', 'for_rent'])
            ? 'https://schema.org/InStock'
            : 'https://schema.org/SoldOut',
    ],
];

if ($firstImage) {
    $schema['image'] = $firstImage;
}

// AggregateRating — only if at least 1 approved review
if (Schema::hasTable('property_reviews')) {
    $reviews = $property->approvedReviews ?? $property->reviews()->where('is_approved', true)->get();
    if ($reviews->isNotEmpty()) {
        $avg = round($reviews->avg('rating'), 1);
        $schema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $avg,
            'reviewCount' => $reviews->count(),
            'bestRating' => 5,
            'worstRating' => 1,
        ];
    }
}
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
