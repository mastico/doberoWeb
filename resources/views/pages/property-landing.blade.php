<x-layouts.app :title="$title" :canonical="$canonical">
    <div style="margin-top:68px">

        {{-- SEO Hero --}}
        <section class="bg-navy py-16 text-white">
            <div class="houzez-container text-center">
                <h1 class="text-3xl font-bold lg:text-4xl">{{ $title }}</h1>
                @if ($intro)
                    <p class="mx-auto mt-4 max-w-2xl text-white/80">{{ $intro->content }}</p>
                @endif
            </div>
        </section>

        {{-- Listings --}}
        <section class="py-12">
            <div class="houzez-container">
                @if ($properties->isEmpty())
                    <p class="py-16 text-center text-slate-500">No properties found for this search. <a href="{{ route('properties.index') }}" class="text-dobero-blue underline">Browse all properties</a>.</p>
                @else
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($properties as $property)
                            <x-property-card :property="$property" />
                        @endforeach
                    </div>
                    <div class="mt-10">{{ $properties->links() }}</div>
                @endif
            </div>
        </section>

    </div>
</x-layouts.app>
