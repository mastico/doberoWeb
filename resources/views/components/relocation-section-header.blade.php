@props(['icon' => '', 'title' => '', 'badge' => null])
<div class="flex items-center gap-4 pt-4">
    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#eaf3fa] text-dobero-blue">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
            {!! $icon !!}
        </svg>
    </div>
    <div class="flex items-center gap-3">
        <h2 class="font-sans text-[1.35rem] font-semibold text-navy">{{ $title }}</h2>
        @if($badge)
            <span class="inline-block rounded-full bg-dobero-blue/10 px-2.5 py-0.5 font-sans text-[11px] font-semibold text-dobero-blue">{{ $badge }}</span>
        @endif
    </div>
</div>
