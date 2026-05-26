@if($section?->is_active)
    <section class="bg-white section-shell">
        <div class="houzez-container">
            <div class="reveal mb-10 text-center">
                <h2 class="section-heading">
                    {{ $section?->title ?? 'Display Different Content Types' }}
                </h2>
                @if ($section?->subtitle)
                    <p class="mt-3 section-body mx-auto max-w-xl">{{ $section->subtitle }}</p>
                @endif
            </div>

            @if ($featuredProperties->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                    @foreach ($featuredProperties as $index => $property)
                        @php
                            $image = $property->images[0] ?? '/images/defaults/property-placeholder.jpg';
                            $src   = image_url($image);
                            $type  = ucfirst(str_replace('_', ' ', $property->property_type));
                        @endphp
                        <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                           class="img-tile group reveal reveal-delay-{{ ($index % 3) + 1 }} aspect-[4/3]">
                            <img src="{{ $src }}" alt="{{ $property->title }}">
                            {{-- Dark overlay on hover --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/70 via-transparent to-transparent opacity-80 transition duration-400 group-hover:opacity-100"></div>
                            {{-- Bottom bar --}}
                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <span class="mb-1.5 inline-block bg-primary px-2.5 py-0.5 font-nav text-[11px] uppercase tracking-wider text-white">
                                    {{ $type }}
                                </span>
                                <h3 class="font-sans text-[14px] font-semibold text-white leading-snug line-clamp-2">
                                    {{ $property->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 text-center reveal">
                    <a href="{{ route('properties.index') }}" class="btn-outline-primary">{{ __('View All Properties') }}</a>
                </div>
            @else
                <p class="py-16 text-center text-muted">{{ __('No featured listings yet.') }}</p>
            @endif
        </div>
    </section>
@endif


