@props(['page'])
@php
use App\Models\FaqItem;
use Illuminate\Support\Facades\Schema;

$faqs = Schema::hasTable('faq_items')
    ? FaqItem::forPage($page)->active()->ordered()->get()
    : collect();

$locale = app()->getLocale();

$schema = [];
if ($faqs->isNotEmpty()) {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqs->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq->getTranslation('question', $locale, false) ?: $faq->getTranslation('question', 'en', false),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => strip_tags($faq->getTranslation('answer', $locale, false) ?: $faq->getTranslation('answer', 'en', false)),
            ],
        ])->values()->all(),
    ];
}
@endphp
@if ($faqs->isNotEmpty())
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endif

