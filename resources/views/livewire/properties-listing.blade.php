<div style="margin-top:68px">
    {{-- Filter bar --}}
    <section class="bg-ink text-paper">
        <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
            <div class="grid gap-4 lg:grid-cols-[2fr_1fr_1fr_auto] lg:items-end">
                <div>
                    <label class="form-label text-white/60">Keyword</label>
                    <input type="text" wire:model.live.debounce.300ms="keyword"
                           placeholder="City, title or address…"
                           class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white placeholder:text-white/35 focus:border-brass-light focus:ring-0">
                </div>
                <div>
                    <label class="form-label text-white/60">Type</label>
                    <select wire:model.live="type"
                            class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white focus:border-brass-light focus:ring-0">
                        <option value="">All Types</option>
                        @foreach ($propertyTypes as $option)
                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label text-white/60">Status</label>
                    <select wire:model.live="status"
                            class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white focus:border-brass-light focus:ring-0">
                        <option value="">Any Status</option>
                        @foreach ($statuses as $option)
                            <option value="{{ $option }}">{{ ucwords(str_replace('_', ' ', $option)) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" wire:click="$toggle('showAdvanced')"
                        class="border border-brass/70 px-5 py-3 font-mono text-[10px] uppercase tracking-widest text-brass-light transition hover:bg-brass hover:text-ink whitespace-nowrap">
                    {{ $showAdvanced ? '− Less' : '+ More filters' }}
                </button>
            </div>

            @if ($showAdvanced)
                <div class="mt-6 grid gap-4 border-t border-white/10 pt-6 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="form-label text-white/60">Min Price €</label>
                        <input type="number" wire:model.live="minPrice"
                               class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white focus:border-brass-light focus:ring-0">
                    </div>
                    <div>
                        <label class="form-label text-white/60">Max Price €</label>
                        <input type="number" wire:model.live="maxPrice"
                               class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white focus:border-brass-light focus:ring-0">
                    </div>
                    <div>
                        <label class="form-label text-white/60">Sort By</label>
                        <select wire:model.live="sort"
                                class="w-full border-0 border-b border-white/20 bg-transparent px-0 py-3 text-sm text-white focus:border-brass-light focus:ring-0">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                            <option value="price_asc">Price: Low → High</option>
                            <option value="price_desc">Price: High → Low</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="button" wire:click="$set('viewMode', 'grid')"
                                class="flex-1 py-3 font-mono text-[10px] uppercase tracking-widest transition
                                       {{ $viewMode === 'grid' ? 'bg-brass text-ink' : 'border border-white/20 text-white/70 hover:text-white' }}">
                            Grid
                        </button>
                        <button type="button" wire:click="$set('viewMode', 'list')"
                                class="flex-1 py-3 font-mono text-[10px] uppercase tracking-widest transition
                                       {{ $viewMode === 'list' ? 'bg-brass text-ink' : 'border border-white/20 text-white/70 hover:text-white' }}">
                            List
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Results --}}
    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-4 border-b border-ink/10 pb-8 md:flex-row md:items-end">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-widest text-ink/45">Properties / Listing</p>
                <h1 class="mt-2 font-display text-3xl text-ink">Listing</h1>
                <p class="mt-1 font-mono text-[10px] uppercase tracking-widest text-ink/50">{{ $properties->total() }} properties found</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="$set('viewMode', 'grid')"
                        class="px-4 py-2 font-mono text-[10px] uppercase tracking-widest transition
                               {{ $viewMode === 'grid' ? 'bg-ink text-paper' : 'border border-ink/20 text-ink/60 hover:text-ink' }}">
                    ▦ Grid
                </button>
                <button type="button" wire:click="$set('viewMode', 'list')"
                        class="px-4 py-2 font-mono text-[10px] uppercase tracking-widest transition
                               {{ $viewMode === 'list' ? 'bg-ink text-paper' : 'border border-ink/20 text-ink/60 hover:text-ink' }}">
                    ☰ List
                </button>
            </div>
        </div>

        <div class="mt-10 {{ $viewMode === 'grid' ? 'grid gap-6 xl:grid-cols-2' : 'space-y-6' }}">
            @forelse ($properties as $property)
                @php
                            $image = $property->images[0] ?? '/images/defaults/property-placeholder.jpg';
                    $src = image_url($image);
                @endphp
                <article class="group border border-ink/10 bg-white {{ $viewMode === 'list' ? 'flex' : '' }}">
                    <div class="relative overflow-hidden {{ $viewMode === 'list' ? 'w-72 shrink-0' : '' }}">
                        <img src="{{ $src }}" alt="{{ $property->title }}"
                             class="{{ $viewMode === 'grid' ? 'h-64' : 'h-full min-h-[180px]' }} w-full object-cover transition duration-700 group-hover:scale-105">
                        @if ($property->is_featured)
                            <div class="absolute left-4 top-4 bg-brass px-3 py-1 font-mono text-[10px] uppercase tracking-widest text-ink">Featured</div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                   class="font-display text-xl leading-snug text-ink transition hover:text-tide">
                                    {{ $property->title }}
                                </a>
                                <p class="mt-1 text-sm text-ink/55">{{ $property->address }}{{ $property->city ? ', '.$property->city : '' }}</p>
                            </div>
                            <span class="shrink-0 bg-bone px-3 py-1 font-mono text-[10px] uppercase tracking-widest text-tide">
                                {{ ucfirst(str_replace('_', ' ', $property->property_type)) }}
                            </span>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-5 font-mono text-[10px] uppercase tracking-widest text-ink/60">
                            @if ($property->bedrooms) <span>{{ $property->bedrooms }} beds</span> @endif
                            @if ($property->bathrooms) <span>{{ $property->bathrooms }} baths</span> @endif
                            @if ($property->sqm) <span>{{ number_format($property->sqm, 0) }} m²</span> @endif
                        </div>

                        <div class="mt-auto flex items-center justify-between pt-6">
                            <div class="price-chip tnum">€{{ number_format($property->price, 0) }}</div>
                            <a href="{{ route('properties.show', ['slug' => $property->slug]) }}" class="btn-primary text-xs py-2.5 px-5">
                                Details <span class="arrow">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="border border-ink/10 bg-white py-20 text-center {{ $viewMode === 'grid' ? 'xl:col-span-2' : '' }}">
                    <p class="font-mono text-[10px] uppercase tracking-widest text-ink/40">No properties match your filters.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">{{ $properties->links() }}</div>
    </section>
</div>
