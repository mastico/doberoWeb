@php
use App\Models\SiteSetting;

$sameAs = array_filter([
    SiteSetting::get('social_facebook'),
    SiteSetting::get('social_instagram'),
    SiteSetting::get('social_twitter'),
    SiteSetting::get('gbp_url'),
]);

$schema = [
    '@context' => 'https://schema.org',
    '@type' => ['Organization', 'RealEstateAgent'],
    'name' => SiteSetting::get('site_name', config('app.name')),
    'url' => url('/'),
    'telephone' => SiteSetting::get('contact_phone'),
    'email' => SiteSetting::get('contact_email'),
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Costa Blanca',
        'addressCountry' => 'ES',
        'streetAddress' => SiteSetting::get('contact_address'),
    ],
    'sameAs' => array_values($sameAs),
];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
