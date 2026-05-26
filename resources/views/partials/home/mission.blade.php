@php
    $stats = data_get($section?->extra ?? [], 'stats', [
        ['icon' => 'nie', 'label' => 'EXPRESS NIE NUMBER', 'value' => '24-48H'],
        ['icon' => 'mortgage', 'label' => 'MORTGAGE UP TO', 'value' => '80%'],
        ['icon' => 'building', 'label' => 'BUILDING PATHOLOGY', 'value' => ''],
        ['icon' => 'search', 'label' => 'FINDING HIDDEN ERRORS', 'value' => ''],
    ]);
@endphp
@if($section?->is_active)
<section class="bg-navy py-14">
    <div class="houzez-container border-x-white">
        <div class="grid grid-cols-2 gap-x-8 gap-y-10 lg:grid-cols-4">
            @foreach ($stats as $i => $stat)
                @php $statValue = $section?->extraTrans("stats.{$i}.value") ?? ($stat['value'] ?? null); @endphp
                <div class="stat-item reveal reveal-delay-{{ $i + 1 }}">
                    <div class="mb-2 text-primary">
                        @switch($stat['icon'])
                            @case('nie')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/></svg>@break
                            @case('mortgage')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>@break
                            @case('building')<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/></svg>@break
                            @default<svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        @endswitch
                    </div>
                    <span class="font-sans text-[12px] font-medium uppercase tracking-wider text-white/70">{{ $section?->extraTrans("stats.{$i}.label") ?? $stat['label'] }}</span>
                    @if ($statValue)<span class="font-sans text-[24px] font-semibold text-white tnum">{{ $statValue }}</span>@endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
