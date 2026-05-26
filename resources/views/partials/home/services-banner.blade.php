@php
    $bannerExtra = $section?->extra ?? [];
    $image = data_get($bannerExtra, 'image', asset('images/defaults/services-banner.jpg'));
    $defaults = [
        ['title' => 'Buy', 'caption' => 'Curated listings', 'icon' => 'home'],
        ['title' => 'Sell', 'caption' => 'Valuation & match', 'icon' => 'tag'],
        ['title' => 'Rent', 'caption' => 'Long & short term', 'icon' => 'key'],
        ['title' => 'Build', 'caption' => 'Construct & finish', 'icon' => 'wrench'],
    ];
    $items = data_get($bannerExtra, 'items', $defaults);
@endphp
@if($section?->is_active)
<section class="relative overflow-hidden bg-navy py-20 text-white">
    <div class="absolute inset-0 -z-0 opacity-15"><img src="{{ $image }}" alt="" class="h-full w-full object-cover"></div>
    <div class="houzez-container relative z-10">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="reveal">
                <h2 class="font-sans text-[clamp(1.5rem,3vw,2.2rem)] font-semibold leading-tight text-white">{{ $section?->title ?? 'We Represent And Assist You Everywhere' }}</h2>
                <p class="mt-5 font-sans text-[15px] font-light leading-relaxed text-white/75">{{ $section?->subtitle ?? 'One Dobero advisor coordinates buying, selling, leasing and building so you keep speaking with the same person from offer to finishes.' }}</p>
                <a href="{{ route('contact') }}" class="mt-8 inline-block btn-primary">{{ __('Get In Touch') }}</a>
            </div>
            <div class="grid grid-cols-2 gap-4 reveal reveal-delay-2">
                @foreach ($items as $i => $item)
                    <div class="service-card">
                        <div class="text-primary">
                            @switch($item['icon'] ?? 'home')
                                @case('home')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>@break
                                @case('tag')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>@break
                                @case('key')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z"/></svg>@break
                                @default<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l5.653-4.655m5.833-4.329a7.5 7.5 0 0 0-10.607 10.607"/></svg>
                            @endswitch
                        </div>
                        <h3 class="font-sans text-[16px] font-semibold text-white">{{ $section?->extraTrans("items.{$i}.title") ?? $item['title'] }}</h3>
                        <p class="font-sans text-[13px] font-light text-white/70">{{ $section?->extraTrans("items.{$i}.caption") ?? ($item['caption'] ?? '') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
