{{-- About page: team section — photo cards with flip-on-hover --}}
<section id="team" class="bg-[#f0f2f5] py-16">
    <div class="houzez-container">
        <div class="mb-10">
            <h2 class="font-sans text-[2rem] font-semibold text-navy">{{ $section?->title ?? 'Meet our Team' }}</h2>
            @if ($section?->subtitle)
                <p class="mt-2 font-sans text-[14px] text-dobero-blue">{{ $section->subtitle }}</p>
            @endif
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($teamMembers as $i => $member)
                @php
                    $photo = image_url($member->photo, '/images/defaults/avatar-placeholder.jpg');
                    $avatar = 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6b8fa8&color=ffffff&size=400';
                @endphp
                {{-- Flip card container --}}
                <div class="group h-[340px] [perspective:1000px]">
                    <div class="relative h-full w-full transition-transform duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)]">

                        {{-- FRONT: photo + name overlay --}}
                        <div class="absolute inset-0 [backface-visibility:hidden] overflow-hidden rounded-lg shadow-md">
                            <img src="{{ $photo ?: $avatar }}"
                                 alt="{{ $member->name }}"
                                 class="h-full w-full object-cover object-top">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent px-5 pb-5 pt-16">
                                <p class="font-sans text-[15px] font-semibold text-white">{{ $member->name }}</p>
                                <p class="font-sans text-[12px] text-white/75">{{ $member->role }}</p>
                            </div>
                        </div>

                        {{-- BACK: bio + social --}}
                        <div class="absolute inset-0 [backface-visibility:hidden] [transform:rotateY(180deg)] flex flex-col items-center justify-center rounded-lg bg-white shadow-md px-6 py-8 text-center">
                            <div class="mb-4 h-16 w-16 overflow-hidden rounded-full border-2 border-[#dce0e0]">
                                <img src="{{ $photo ?: $avatar }}" alt="{{ $member->name }}" class="h-full w-full object-cover object-top">
                            </div>
                            <p class="font-sans text-[15px] font-semibold text-navy">{{ $member->name }}</p>
                            <p class="mt-0.5 font-sans text-[12px] text-dobero-blue">{{ $member->role }}</p>
                            @if ($member->bio)
                                <p class="mt-3 font-sans text-[12px] leading-relaxed text-body/70 line-clamp-4">{{ $member->bio }}</p>
                            @endif
                            {{-- Social placeholder icons --}}
                            <div class="mt-4 flex gap-3">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#3b5998] text-white text-[11px] font-bold">f</span>
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-black text-white text-[11px] font-bold">𝕏</span>
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#0a66c2] text-white text-[11px] font-bold">in</span>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-4 py-12 text-center text-muted">{{ __('Team members coming soon.') }}</div>
            @endforelse
        </div>
    </div>
</section>
