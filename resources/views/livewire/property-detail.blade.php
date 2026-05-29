@php $images = $property->images ?? []; @endphp
<x-seo.property-schema :property="$property" />

{{-- ── Gallery lightbox (Alpine) ───────────────────── --}}
@if (count($images))
<div
    x-data="{
        open: false,
        current: 0,
        loading: false,
        images: @js(array_values(array_map(fn($img) => image_url($img), $images))),
        prev() { this.loading = true; this.current = (this.current - 1 + this.images.length) % this.images.length },
        next() { this.loading = true; this.current = (this.current + 1) % this.images.length },
        show(i) {
            this.current = i;
            this.open = true;
            this.$nextTick(() => {
                const img = this.$el.querySelector('.lightbox-img');
                this.loading = img ? !img.complete : false;
            });
        }
    }"
    @keydown.escape.window="open = false"
    @keydown.arrow-left.window="if(open) prev()"
    @keydown.arrow-right.window="if(open) next()"
>

<div style="margin-top:68px">

    {{-- ── Hero image + price ───────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-6 pb-4 lg:px-8">
        <div class="relative overflow-hidden">
            <img src="{{ image_url($images[0] ?? null) }}"
                 alt="{{ $property->title }}{{ $property->city ? ' — '.$property->city : '' }}"
                 class="h-[55vh] min-h-[360px] w-full object-cover cursor-pointer"
                 @click="show(0)">
            <div class="absolute inset-0 bg-gradient-to-t from-ink/50 to-transparent pointer-events-none"></div>

            {{-- Bottom bar --}}
            <div class="absolute inset-x-0 bottom-0 p-8 pointer-events-none">
                <div class="text-paper">
                    <p class="font-mono text-[10px] uppercase tracking-widest text-white/70">
                        {{ $property->address }}{{ $property->city ? ', '.$property->city : '' }}
                    </p>
                    <h1 class="mt-2 font-display text-3xl text-paper md:text-4xl">{{ $property->title }}</h1>
                </div>
            </div>

            {{-- Price — bottom right (swapped with view-all button) --}}
            <div class="absolute right-6 bottom-6 price-chip text-2xl tnum pointer-events-none">
                €{{ number_format($property->price, 0) }}
            </div>

            {{-- Status badge --}}
            <div class="absolute left-6 top-6 status-chip pointer-events-none">
                {{ ucwords(str_replace('_', ' ', $property->status ?? 'For Sale')) }}
            </div>

            {{-- View all photos button — top right (swapped with price) --}}
            @if (count($images) > 1)
            <button @click="show(0)"
                    class="absolute top-6 right-6 flex items-center gap-2 bg-white/90 hover:bg-white px-4 py-2 text-xs font-mono uppercase tracking-widest text-ink shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                {{ __('View all') }} {{ count($images) }} {{ __('photos') }}
            </button>
            @endif
        </div>

        {{-- Thumbnail strip --}}
        @if (count($images) > 1)
            <div class="mt-2 flex gap-2 overflow-x-auto">
                @foreach ($images as $i => $img)
                    <img src="{{ image_url($img) }}"
                         alt="{{ $property->title }} — image {{ $i + 1 }}"
                         loading="lazy"
                         @click="show({{ $i }})"
                         class="h-20 w-28 shrink-0 object-cover opacity-80 hover:opacity-100 transition cursor-pointer">
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── Body ────────────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="grid gap-10 xl:grid-cols-[1fr_380px]">

            {{-- Left column --}}
            <div class="space-y-8">

                {{-- Quick stats bar --}}
                <div class="grid grid-cols-2 gap-px bg-ink/10 sm:grid-cols-4">
                    <div class="bg-white px-5 py-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-ink/50">Type</p>
                        <p class="mt-2 font-display text-lg text-ink">{{ ucfirst($property->property_type) }}</p>
                    </div>
                    <div class="bg-white px-5 py-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-ink/50">Bedrooms</p>
                        <p class="mt-2 font-display text-lg text-ink">{{ $property->bedrooms ?? '—' }}</p>
                    </div>
                    <div class="bg-white px-5 py-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-ink/50">Bathrooms</p>
                        <p class="mt-2 font-display text-lg text-ink">{{ $property->bathrooms ?? '—' }}</p>
                    </div>
                    <div class="bg-white px-5 py-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-ink/50">Size</p>
                        <p class="mt-2 font-display text-lg text-ink tnum">{{ $property->sqm ? number_format($property->sqm, 0).' m²' : '—' }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div class="border border-ink/10 bg-white p-8">
                    <h2 class="font-display text-2xl text-ink">Description</h2>
                    <p class="mt-5 text-sm leading-8 text-ink/75">{{ $property->description }}</p>
                </div>

                {{-- Details --}}
                <div class="border border-ink/10 bg-white p-8">
                    <h2 class="font-display text-2xl text-ink">Property Details</h2>
                    <dl class="mt-6 grid gap-px bg-ink/10 sm:grid-cols-2">
                        @foreach ([
                            'Property ID' => $property->property_id_ref ?: 'N/A',
                            'Price'        => '€'.number_format($property->price, 0),
                            'Bedrooms'     => $property->bedrooms,
                            'Bathrooms'    => $property->bathrooms,
                            'Size'         => number_format($property->sqm, 0).' m²',
                            'Type'         => ucfirst($property->property_type),
                        ] as $label => $value)
                            <div class="flex items-center justify-between bg-white px-5 py-4">
                                <dt class="font-mono text-[10px] uppercase tracking-widest text-ink/50">{{ $label }}</dt>
                                <dd class="font-display text-base text-ink tnum">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                {{-- Address --}}
                <div class="border border-ink/10 bg-white p-8">
                    <h2 class="font-display text-2xl text-ink">Location</h2>
                    <dl class="mt-6 grid gap-px bg-ink/10 sm:grid-cols-2">
                        @foreach ([
                            'Address'      => $property->address,
                            'City'         => $property->city,
                            'State/Country'=> $property->state_country,
                            'Postal Code'  => $property->postal_code,
                        ] as $label => $value)
                            @if ($value)
                                <div class="flex items-center justify-between bg-white px-5 py-4">
                                    <dt class="font-mono text-[10px] uppercase tracking-widest text-ink/50">{{ $label }}</dt>
                                    <dd class="text-sm text-ink">{{ $value }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                </div>

                {{-- Mortgage Calculator --}}
                <div
                    x-data="{
                        amount: {{ (int) $property->price }},
                        down: 20, rate: 4.5, years: 25, tax: 150,
                        get principal() { return this.amount * ((100 - this.down) / 100); },
                        get monthlyRate() { return (this.rate / 100) / 12; },
                        get months() { return this.years * 12; },
                        get payment() {
                            let r = this.monthlyRate, n = this.months;
                            if (!r) return (this.principal / n) + Number(this.tax);
                            return ((this.principal * r) / (1 - Math.pow(1 + r, -n))) + Number(this.tax);
                        }
                    }"
                    class="border border-ink/10 bg-white p-8"
                >
                    <h2 class="font-display text-2xl text-ink">Mortgage Calculator</h2>

                    <div class="mt-8 grid gap-10 xl:grid-cols-[220px_1fr]">
                        {{-- Donut display --}}
                        <div class="flex flex-col items-center justify-center border border-ink/10 py-10 px-8 text-center">
                            <p class="font-mono text-[10px] uppercase tracking-widest text-ink/50">Monthly payment</p>
                            <p class="mt-3 font-display text-4xl text-tide tnum">€<span x-text="payment.toFixed(0)"></span></p>
                            <div class="mt-4 h-px w-12 bg-brass/60 mx-auto"></div>
                            <p class="mt-3 font-mono text-[10px] uppercase tracking-widest text-ink/50">
                                <span x-text="years"></span> year term
                            </p>
                        </div>

                        {{-- Sliders --}}
                        <div class="space-y-6">
                            @foreach ([
                                ['label' => 'Property Value', 'model' => 'amount', 'min' => 50000, 'max' => 3000000, 'step' => 5000, 'prefix' => '€', 'suffix' => ''],
                                ['label' => 'Down Payment', 'model' => 'down', 'min' => 0, 'max' => 80, 'step' => 1, 'prefix' => '', 'suffix' => '%'],
                                ['label' => 'Interest Rate', 'model' => 'rate', 'min' => 1, 'max' => 10, 'step' => 0.1, 'prefix' => '', 'suffix' => '%'],
                                ['label' => 'Loan Term', 'model' => 'years', 'min' => 5, 'max' => 35, 'step' => 1, 'prefix' => '', 'suffix' => ' yrs'],
                                ['label' => 'Property Tax / mo', 'model' => 'tax', 'min' => 0, 'max' => 1000, 'step' => 10, 'prefix' => '€', 'suffix' => ''],
                            ] as $slider)
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label class="font-mono text-[10px] uppercase tracking-widest text-ink/55">{{ $slider['label'] }}</label>
                                        <span class="font-mono text-[11px] text-brass tnum">
                                            {{ $slider['prefix'] }}<span x-text="{{ $slider['model'] }}"></span>{{ $slider['suffix'] }}
                                        </span>
                                    </div>
                                    <input type="range"
                                           min="{{ $slider['min'] }}" max="{{ $slider['max'] }}" step="{{ $slider['step'] }}"
                                           x-model="{{ $slider['model'] }}"
                                           class="mt-2 h-px w-full cursor-pointer appearance-none bg-ink/15 [&::-webkit-slider-thumb]:h-3.5 [&::-webkit-slider-thumb]:w-3.5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:bg-brass [&::-webkit-slider-thumb]:rounded-none">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Reviews --}}
                <div class="border border-ink/10 bg-white p-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="font-display text-2xl text-ink">Reviews</h2>
                        <span class="font-mono text-[10px] uppercase tracking-widest text-ink/50">{{ $approvedReviews->count() }} reviews</span>
                    </div>

                    <div class="mt-6 divide-y divide-ink/10">
                        @forelse ($approvedReviews as $review)
                            <div class="py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="font-display text-base text-ink">{{ $review->title }}</h3>
                                    <span class="shrink-0 text-brass text-sm">{{ str_repeat('★', $review->rating) }}</span>
                                </div>
                                <p class="mt-2 text-sm leading-7 text-ink/70">{{ $review->review }}</p>
                                <p class="mt-2 font-mono text-[10px] uppercase tracking-widest text-ink/45">— {{ $review->author_name }}</p>
                            </div>
                        @empty
                            <p class="py-5 text-sm text-ink/50">No reviews yet. Be the first.</p>
                        @endforelse
                    </div>

                    <form wire:submit="submitReview" class="mt-8 grid gap-5 border-t border-ink/10 pt-8 md:grid-cols-2">
                        @if (session('review_success'))
                            <div class="md:col-span-2 border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('review_success') }}</div>
                        @endif
                        <div class="md:col-span-2">
                            <label class="form-label">Review Title</label>
                            <input type="text" wire:model="reviewForm.title" class="form-input">
                            @error('reviewForm.title') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Rating</label>
                            <select wire:model="reviewForm.rating" class="form-input">
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Your Name</label>
                            <input type="text" wire:model="reviewForm.author_name" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="reviewForm.author_email" class="form-input">
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Review</label>
                            <textarea wire:model="reviewForm.review" rows="4" class="form-input"></textarea>
                            @error('reviewForm.review') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button class="btn-primary">Submit review <span class="arrow">→</span></button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right sidebar --}}
            <div class="space-y-6">
                {{-- Schedule a Tour --}}
                <div class="border border-ink/10 bg-white p-7">
                    <h2 class="font-display text-xl text-ink">Schedule a Tour</h2>
                    <form wire:submit="submitTour" class="mt-6 space-y-5">
                        @if (session('tour_success'))
                            <div class="border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('tour_success') }}</div>
                        @endif
                        <div>
                            <label class="form-label">Tour Type</label>
                            <select wire:model="tour.tour_type" class="form-input">
                                <option value="phone">Phone</option>
                                <option value="in_person">In-Person</option>
                                <option value="video_chat">Video Chat</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Date</label>
                                <input type="date" wire:model="tour.date" class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Time</label>
                                <input type="time" wire:model="tour.time" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Name</label>
                            <input type="text" wire:model="tour.name" class="form-input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Phone</label>
                                <input type="text" wire:model="tour.phone" class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" wire:model="tour.email" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Message</label>
                            <textarea wire:model="tour.message" rows="3" class="form-input"></textarea>
                        </div>
                        <button class="btn-primary w-full justify-center">Book tour <span class="arrow">→</span></button>
                    </form>
                </div>

                {{-- Enquiry --}}
                <div class="border border-brass/40 bg-bone p-7">
                    <h2 class="font-display text-xl text-ink">Enquire About This Property</h2>
                    <form wire:submit="submitInquiry" class="mt-6 space-y-5">
                        @if (session('inquiry_success'))
                            <div class="border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('inquiry_success') }}</div>
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">First Name</label>
                                <input type="text" wire:model="inquiry.first_name" class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Last Name</label>
                                <input type="text" wire:model="inquiry.last_name" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="inquiry.email" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="text" wire:model="inquiry.phone" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Message</label>
                            <textarea wire:model="inquiry.message" rows="4" class="form-input"></textarea>
                        </div>
                        <button class="btn-accent w-full justify-center">Send enquiry <span class="arrow">→</span></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Similar listings ─────────────────────────────── --}}
    @if ($similarListings->isNotEmpty())
        <section class="border-t border-ink/10 bg-bone py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <p class="eyebrow mb-10">— Similar Listings</p>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($similarListings as $listing)
                        @php $img = $listing->images[0] ?? '/images/defaults/property-placeholder.jpg'; @endphp
                        <a href="{{ route('properties.show', ['slug' => $listing->slug]) }}" class="group border border-ink/10 bg-white">
                            <div class="overflow-hidden">
                                <img src="{{ image_url($img) }}"
                                     alt="{{ $listing->title }}"
                                     loading="lazy"
                                     class="h-52 w-full object-cover transition duration-700 group-hover:scale-105">
                            </div>
                            <div class="p-5">
                                <h3 class="font-display text-lg text-ink">{{ $listing->title }}</h3>
                                <p class="mt-1 text-sm text-ink/55">{{ $listing->city }}</p>
                                <p class="mt-3 price-chip inline-flex text-sm tnum">€{{ number_format($listing->price, 0) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</div>{{-- end margin-top wrapper --}}

{{-- ── Lightbox modal ───────────────────────────────── --}}
<div x-show="open"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90"
     @click.self="open = false">

    {{-- Close --}}
    <button @click="open = false"
            class="absolute right-5 top-5 text-white/70 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Counter --}}
    <div class="absolute left-5 top-5 font-mono text-xs uppercase tracking-widest text-white/60">
        <span x-text="current + 1"></span> / <span x-text="images.length"></span>
    </div>

    {{-- Prev --}}
    <button @click="prev"
            class="absolute left-4 top-1/2 -translate-y-1/2 p-2 text-white/70 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    {{-- Image --}}
    <div class="relative flex items-center justify-center">
        {{-- Spinner --}}
        <div x-show="loading" class="absolute inset-0 flex items-center justify-center">
            <svg class="h-10 w-10 animate-spin text-white/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
        </div>
        <img :src="images[current]"
             :alt="'{{ $property->title }} — photo ' + (current + 1)"
             :class="loading ? 'opacity-0' : 'opacity-100'"
             class="lightbox-img max-h-[88vh] max-w-[90vw] object-contain select-none transition-opacity duration-200"
             x-on:load="loading = false"
             x-on:error="loading = false">
    </div>

    {{-- Next --}}
    <button @click="next"
            class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-white/70 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dot strip --}}
    @if (count($images) > 1)
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach ($images as $i => $img)
            <button @click="current = {{ $i }}"
                    :class="{{ $i }} === current ? 'bg-white' : 'bg-white/30'"
                    class="h-1.5 w-1.5 rounded-full transition-colors"></button>
        @endforeach
    </div>
    @endif
</div>

</div>{{-- end Alpine x-data --}}
@endif{{-- end if images --}}
