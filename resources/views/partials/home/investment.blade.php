@php
    $investmentExtra = $section?->extra ?? [];
    $images = data_get($investmentExtra, 'images', [asset('images/defaults/investment-studio.jpg'), asset('images/defaults/investment-2.jpg'), asset('images/defaults/investment-3.jpg'), asset('images/defaults/investment-4.jpg')]);
    $btnLabel = $section?->extraTrans('button_label') ?? data_get($investmentExtra, 'button_label', 'View Properties');
    $btnUrl = data_get($investmentExtra, 'button_url', route('properties.index'));
    $bullets = data_get($investmentExtra, 'bullets', ['Complete Documentation', 'Transferring Utility Meters', 'Redesigning Property', 'Obtain All The Licences', 'Refurbishment']);
@endphp
@php
    $propertyTypes = [
        ['title' => 'Studio',    'properties' => 4,   'image' => asset('images/defaults/investment-studio.jpg'), 'class' => 'lg:row-span-2'],
        ['title' => 'Flat',      'properties' => 485, 'image' => asset('images/defaults/investment-flat.jpg'),   'class' => ''],
        ['title' => 'Penthouse', 'properties' => 6,   'image' => asset('images/defaults/investment-flat.jpg'),   'class' => 'lg:row-span-2'],
        ['title' => 'House',     'properties' => 72,  'image' => asset('images/defaults/investment-house.jpg'),  'class' => ''],
        ['title' => 'Duplex',    'properties' => 13,  'image' => asset('images/defaults/investment-duplex.jpg'), 'class' => ''],
        ['title' => 'Bungalow',  'properties' => 5,   'image' => asset('images/defaults/investment-studio.jpg'), 'class' => ''],
    ];
@endphp
@if($section?->is_active)
<section class="bg-[#f5f5f5] py-20">
    <div class="mx-auto max-w-7xl px-6">

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            {{-- LEFT TEXT --}}
            <div class="lg:col-span-3">
                <h2 class="section-heading">{{ $section?->title ?? 'You Can Find Your Perfect Investment' }}</h2>
                <p class="mt-5 section-body">{{ $section?->content ?? 'Browse a portfolio of contemporary apartments, sea-view villas, and value-add properties selected for location quality, resale potential, and renovation upside.' }}</p>
                @if ($bullets)
                    <div class="mt-8 space-y-2 text-gray-500">
                        <p class="font-sans text-[14px] font-semibold text-navy mb-3">{{ __('After it We Will Do:') }}</p>
                        <ul class="space-y-2">
                            @foreach ($bullets as $index => $bullet)
                                <li class="flex items-center gap-3 font-sans text-[14px] text-muted"><svg class="h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>{{ $section?->extraTrans("bullets.{$index}") ?? $bullet }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <a href="{{ $btnUrl }}" class="mt-8 inline-block btn-primary">{{ $btnLabel }}</a>
            </div>


            {{-- RIGHT GRID --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:col-span-9 lg:grid-cols-3">

                {{-- COLUMN 1 --}}
                <div class="space-y-6">

                    {{-- Flat --}}
                    <x-property-card
                        :title="__('Flat')"
                        properties="485"
                        image="{{ $propertyTypes[1]['image'] }}"
                        height="h-[280px]"
                    />

                    {{-- Studio --}}
                    <x-property-card
                        :title="__('Studio')"
                        properties="4"
                        image="{{ $propertyTypes[0]['image'] }}"
                        height="h-[560px]"
                    />

                </div>

                {{-- COLUMN 2 --}}
                <div class="space-y-6 pt-14">

                    {{-- House --}}
                    <x-property-card
                        :title="__('House')"
                        properties="72"
                        image="{{ $propertyTypes[3]['image'] }}"
                        height="h-[280px]"
                    />

                    {{-- Duplex --}}
                    <x-property-card
                        :title="__('Duplex')"
                        properties="13"
                        image="{{ $propertyTypes[4]['image'] }}"
                        height="h-[280px]"
                    />

                </div>

                {{-- COLUMN 3 --}}
                <div class="space-y-6">

                    {{-- Penthouse --}}
                    <x-property-card
                        :title="__('Penthouse')"
                        properties="6"
                        image="{{ $propertyTypes[2]['image'] }}"
                        height="h-[560px]"
                    />

                    {{-- Bungalow --}}
                    <x-property-card
                        :title="__('Bungalow')"
                        properties="5"
                        image="{{ $propertyTypes[5]['image'] }}"
                        height="h-[220px]"
                    />

                </div>

            </div>

        </div>

    </div>
</section>
@endif
