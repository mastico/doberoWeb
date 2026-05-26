@php
    $logos = data_get($section?->extra ?? [], 'logos', ['Idealista', 'Fotocasa', 'Habitaclia', 'Kyero', 'Rightmove']);
@endphp
@if($section?->is_active)
<section class="bg-white border-t border-[#dce0e0] py-14">
    <div class="houzez-container">
        <div class="reveal grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($logos as $index => $logo)
                @php $value = $section?->extraTrans("logos.{$index}") ?? $logo; @endphp
                <div class="partner-item">
                    @if (filter_var($value, FILTER_VALIDATE_URL))
                        <img src="{{ $value }}" alt="" class="max-h-10 w-auto object-contain">
                    @else
                        <span class="font-sans text-[13px] font-semibold uppercase tracking-wider text-muted">{{ $value }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
