{{-- About page intro section --}}
@php
    $locale = app()->getLocale();
    $keywords = [
        'en' => [
            ['word' => 'Destinations',  'desc' => 'Discover your perfect destination'],
            ['word' => 'Oasis',         'desc' => 'Your oasis of tranquility'],
            ['word' => 'Breeze',        'desc' => 'Seamless and stress-free process'],
            ['word' => 'Elegance',      'desc' => 'Elegant properties, sophisticated service'],
            ['word' => 'Retreat',       'desc' => 'Your perfect coastal retreat'],
            ['word' => 'Outstanding',   'desc' => 'Outstanding service and results'],
        ],
        'hu' => [
            ['word' => 'Döntés',        'desc' => 'Segítünk a legjobb döntés meghozatalában'],
            ['word' => 'Otthonod',      'desc' => 'Az Ön álmai otthona a Costa Blancán'],
            ['word' => 'Bizalom',       'desc' => 'Megbízható szolgáltatások szakértői csapatunktól'],
            ['word' => 'Előnyök',       'desc' => 'Díjmentes dokumentáció az ingatlanvásárláshoz'],
            ['word' => 'Relaxáció',     'desc' => 'Stresszmentes ügyintézés'],
            ['word' => 'Oázis',         'desc' => 'Nyugalom, kényelem, a Costa Blanca oázisa'],
        ],
        'es' => [
            ['word' => 'Destinos',      'desc' => 'Destinos de ensueño en la Costa Blanca'],
            ['word' => 'Oportunidad',   'desc' => 'Oportunidad de inversión única'],
            ['word' => 'Bienestar',     'desc' => 'Bienestar y tranquilidad en tu nuevo hogar'],
            ['word' => 'Elegantes',     'desc' => 'Elegantes propiedades, servicio sofisticado'],
            ['word' => 'Refugio',       'desc' => 'Tu refugio costero perfecto'],
            ['word' => 'Optimo',        'desc' => 'Servicio óptimo y resultados excepcionales'],
        ],
    ];
    $kw = $keywords[$locale] ?? $keywords['en'];
@endphp
<section class="bg-white py-12 border-b border-[#e0e6ea]">
    <div class="houzez-container">

        {{-- Big subtitle --}}
        <h2 class="font-sans text-[1.7rem] font-semibold text-navy mb-8 leading-snug">
            {{ $section?->subtitle ?? 'The DOBERO team offers more than just a "property in Spain"!' }}
        </h2>

        {{-- Two-column body --}}
        <div class="grid gap-8 lg:grid-cols-2">

            {{-- Left: section title + main content --}}
            <div class="space-y-5">
                <p class="font-sans text-[11px] uppercase tracking-widest font-semibold text-dobero-blue">
                    {{ $section?->title ?? 'WE CREATE NEW LIFES AND NEW HOMES ON THE COSTA BLANCA!' }}
                </p>
                <p class="font-sans text-[15px] leading-relaxed text-body font-semibold">
                    {{ $section?->content ?? '' }}
                </p>
                <p class="font-sans text-[14px] leading-relaxed text-body/80 italic">
                    {{ $section?->extraTrans('column_two') ?? '' }}
                </p>
            </div>

            {{-- Right: keyword list --}}
            <div class="space-y-2">
                @foreach ($kw as $item)
                    <p class="font-sans text-[14px] text-dobero-blue leading-relaxed">
                        <span class="font-bold">{{ substr($item['word'], 0, 1) }}</span>{{ substr($item['word'], 1) }}
                        <span class="text-body/70">({{ $item['desc'] }})</span>
                    </p>
                @endforeach
            </div>
        </div>

    </div>
</section>
