@php
    $heroExtra = $section?->extra ?? [];
    $heroImage = data_get($heroExtra, 'hero_image') ?: asset('images/hero-bg.jpg');
    $primaryCta = data_get($heroExtra, 'primary_cta', []);
    $primaryUrl = isset($primaryCta['route']) ? route($primaryCta['route']) : data_get($primaryCta, 'url', route('properties.index'));
    $primaryLabel = $section?->extraTrans('primary_cta.label') ?? data_get($primaryCta, 'label', 'Explore Properties');
    $secondaryCta = data_get($heroExtra, 'secondary_cta', []);
    $secondaryUrl = isset($secondaryCta['route']) ? route($secondaryCta['route']) : data_get($secondaryCta, 'url', route('contact'));
    $secondaryLabel = $section?->extraTrans('secondary_cta.label') ?? data_get($secondaryCta, 'label', 'Contact Us');
@endphp
@if($section?->is_active)
<section class="relative min-h-screen overflow-hidden bg-navy text-white">
    <div class="absolute inset-0">
        <img src="{{ $heroImage }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 pb-16 pt-32 text-center">
        <h1 class="animate-rise font-sans text-[clamp(2rem,5vw,3.4rem)] font-semibold leading-tight text-white max-w-3xl">{{ $section?->title ?? 'Welcome to DOBERO' }}</h1>
        <p class="animate-rise mt-6 max-w-2xl font-sans text-[16px] font-light leading-relaxed text-white/80" style="animation-delay:.15s">{{ $section?->subtitle ?? 'The DOBERO team is who realize your spanish home! The key to your spanish home is here with us!' }}</p>
        <div class="animate-rise mt-10 flex flex-col items-center gap-4 sm:flex-row" style="animation-delay:.28s">
            <a href="{{ $primaryUrl }}" class="btn-primary">{{ $primaryLabel }}</a>
            <a href="{{ $secondaryUrl }}" class="btn-outline">{{ $secondaryLabel }}</a>
        </div>
        @include('partials.home.pillars', ['section' => $this->sections['hero']])
    </div>
</section>
@endif
