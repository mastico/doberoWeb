@php
    $btnLabel = $section?->extraTrans('button_label') ?? data_get($section?->extra ?? [], 'button_label', 'Learn More');
    $btnUrl = localize_url(data_get($section?->extra ?? [], 'button_url', locale_route('about')));
@endphp
@if($section?->is_active)
<section class="bg-white section-shell">
    <div class="houzez-container">
        <div class="grid items-center gap-10 lg:grid-cols-2 reveal">
            <div>
                <h2 class="section-heading">{{ $section?->title ?? 'Real Estate Expertise For Over 40 Years' }}</h2>
                <p class="mt-5 section-body">{{ $section?->content ?? 'We combine estate agency, relocation consulting, building pathology, financing guidance, and local market intelligence. That means fewer surprises and faster decisions for local and international buyers alike.' }}</p>
            </div>
            <div class="flex lg:justify-end reveal reveal-delay-2"><a href="{{ $btnUrl }}" class="btn-primary">{{ $btnLabel }}</a></div>
        </div>
    </div>
</section>
@endif
