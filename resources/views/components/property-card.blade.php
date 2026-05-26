@props([
    'title',
    'properties',
    'image',
    'height' => 'h-[300px]',
])

<a
    href="{{ url('/properties?type=' . strtolower($title)) }}"
    class="group relative block overflow-hidden rounded-sm {{ $height }}"
>

    {{-- Image --}}
    <img
        src="{{ $image }}"
        alt="{{ $title }}"
        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
    >

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/20 transition group-hover:bg-black/30"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">

        <div>
            <p class="text-sm font-light">
                {{ $properties }} Properties
            </p>

            <h3 class="mt-1 text-3xl font-light">
                {{ $title }}
            </h3>
        </div>

        <div class="flex items-center justify-between">

            <span class="text-sm tracking-wide">
                MORE DETAILS
            </span>

            <div class="flex h-8 w-8 items-center justify-center rounded-full border border-white/70">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                    />
                </svg>
            </div>

        </div>

    </div>

</a>
