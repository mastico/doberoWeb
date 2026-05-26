{{-- About page: partner logos --}}
@php
    $logos = [
        ['file' => 'Brochacolor.png',       'name' => 'Brochacolor'],
        ['file' => 'Cargasol.png',           'name' => 'Cargasol'],
        ['file' => 'Cesur.png',              'name' => 'Cesur'],
        ['file' => 'Juanmi.png',             'name' => 'Juanmi'],
        ['file' => 'Leroy Merlin.png',       'name' => 'Leroy Merlin'],
        ['file' => 'Preyser.png',            'name' => 'Preyser'],
        ['file' => 'Tabisam.png',            'name' => 'Tabisam'],
        ['file' => 'Tower Arquitectos.png',  'name' => 'Tower Arquitectos'],
    ];
@endphp
<section id="partners" class="bg-white border-t border-[#dce0e0] py-16">
    <div class="houzez-container">
        <div class="reveal mb-8 text-center">
            <h2 class="section-heading">{{ $section?->title ?? __('Our Partners') }}</h2>
            @if($section?->subtitle)
                <p class="mt-2 section-body mx-auto max-w-xl">{{ $section->subtitle }}</p>
            @endif
        </div>
        <div class="reveal grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 items-center">
            @foreach ($logos as $i => $logo)
                <div class="partner-item reveal-delay-{{ ($i % 4) + 1 }} flex items-center justify-center p-3">
                    <img src="{{ asset('images/partners/'.rawurlencode($logo['file'])) }}"
                         alt="{{ $logo['name'] }}"
                         class="max-h-24 w-auto object-contain grayscale hover:grayscale-0 transition-all duration-300">
                </div>
            @endforeach
        </div>
    </div>
</section>
