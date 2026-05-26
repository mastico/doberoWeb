{{-- About page: 6-card keyword/value grid (locale-aware) --}}
@php
    $locale = app()->getLocale();

    $defaultCards = [
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
            ['word' => 'Előnyök',       'desc' => 'Díjmentes dokumentáció az ingatlanvásárláshoz, kiváló szolgáltatások'],
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

    $cards = data_get($section?->extra ?? [], "cards.{$locale}")
           ?? $defaultCards[$locale]
           ?? $defaultCards['en'];

    $bgColors = [
        'bg-navy',
        'bg-dobero-blue',
        'bg-navy-light',
        'bg-dobero-accent',
        'bg-navy-dark',
        'bg-dobero-blue',
    ];
@endphp

<section class="bg-[#f4f6f8] py-20">
    <div class="houzez-container">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($cards as $i => $card)
                <div class="reveal reveal-delay-{{ $i + 1 }} relative overflow-hidden rounded-lg {{ $bgColors[$i % count($bgColors)] }} p-10 text-white group"
                     style="min-height:200px">
                    <div class="relative z-10">
                        <h3 class="font-sans text-[2rem] font-bold leading-tight">{{ $card['word'] }}</h3>
                        <p class="mt-3 font-sans text-[14px] leading-relaxed text-white/80">{{ $card['desc'] }}</p>
                    </div>
                    {{-- Decorative circle --}}
                    <div class="absolute -bottom-10 -right-10 h-40 w-40 rounded-full bg-white/5 transition-transform duration-500 group-hover:scale-150"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
