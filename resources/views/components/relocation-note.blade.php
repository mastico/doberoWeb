@props([])
<div class="mt-5 flex gap-3 rounded-lg border border-dobero-blue/20 bg-[#eaf3fa] px-5 py-4 not-prose">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0 text-dobero-blue mt-0.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
    </svg>
    <p class="font-sans text-[13px] leading-relaxed text-navy/80">{{ $slot }}</p>
</div>
