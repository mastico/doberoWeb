@if($section?->is_active)
<section class="bg-white section-shell border-t border-[#dce0e0]">
    <div class="houzez-container">
        <div class="reveal mb-10 text-center">
            <h2 class="section-heading">{{ $section?->title ?? 'Testimonials' }}</h2>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            @forelse ($testimonials as $i => $testimonial)
                @php $photo = image_url($testimonial->author_photo, '/images/defaults/avatar-placeholder.jpg'); @endphp
                <div class="testimonial-card reveal reveal-delay-{{ $i + 1 }}">
                    {{-- Avatar + stars --}}
                    <div class="flex items-center gap-4">
                        <img src="{{ $photo ?: asset('images/defaults/avatar-placeholder.jpg') }}"
                             alt="{{ $testimonial->author_name }}"
                             class="h-12 w-12 rounded-full object-cover">
                        <div class="flex gap-0.5 text-yellow-400">
                            @for ($s = 0; $s < 5; $s++)
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    {{-- Quote --}}
                    <p class="flex-1 font-sans text-[14px] italic leading-relaxed text-muted">
                        "{{ $testimonial->content }}"
                    </p>

                    {{-- Author --}}
                    <div class="border-t border-[#dce0e0] pt-5">
                        <p class="font-sans text-[14px] font-semibold text-navy">{{ $testimonial->author_name }}</p>
                        <p class="font-sans text-[12px] text-muted">
                            {{ collect([$testimonial->author_role, $testimonial->author_company])->filter()->join(' · ') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center text-muted">Testimonials coming soon.</div>
            @endforelse
        </div>
    </div>
</section>
@endif
