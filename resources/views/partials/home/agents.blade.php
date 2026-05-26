@if($section?->is_active)
<section class="bg-white section-shell">
    <div class="houzez-container">
        <div class="reveal mb-10 text-center">
            <h2 class="section-heading">
                {{ $section?->title ?? 'We are here to help you!' }}
            </h2>
            @if ($section?->subtitle)
                <p class="mt-3 section-body mx-auto max-w-xl">{{ $section->subtitle }}</p>
            @endif
        </div>

        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($agents as $i => $agent)
                @php $photo = image_url($agent->photo, '/images/defaults/avatar-placeholder.jpg'); @endphp
                <div class="agent-card reveal reveal-delay-{{ $i + 1 }} p-7 text-center">
                    {{-- Circular avatar --}}
                    <div class="mx-auto mb-5 h-24 w-24 overflow-hidden rounded-full border-2 border-[#dce0e0]">
                        <img src="{{ $photo ?: asset('images/defaults/avatar-placeholder.jpg') }}"
                             alt="{{ $agent->name }}"
                             class="h-full w-full object-cover object-top">
                    </div>
                    <h3 class="font-sans text-[16px] font-semibold text-navy">{{ $agent->name }}</h3>
                    <p class="mt-1 font-sans text-[13px] text-primary">{{ __('Company Agent') }}</p>
                    <p class="mt-0.5 font-sans text-[12px] text-muted">{{ $agent->role }}</p>
                    <a href="{{ locale_route('about') }}#team"
                       class="mt-4 inline-block font-sans text-[13px] font-medium text-primary hover:text-navy transition-colors">
                        {{ __('View Profile') }}
                    </a>
                </div>
            @empty
                <div class="col-span-4 py-12 text-center text-muted">{{ __('Team members coming soon.') }}</div>
            @endforelse
        </div>
    </div>
</section>
@endif
