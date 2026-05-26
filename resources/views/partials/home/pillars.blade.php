@php
    $pillars = data_get($section?->extra ?? [], 'pillars', [
        ['label' => 'Our Mission', 'body' => 'Fully aware of our responsibility, we help you find or refurbish your home in Spain with personalized services.'],
        ['label' => 'Our Vision', 'body' => 'Through innovation to achieve a dominant position on the market. Providing the best services to our Customers.'],
        ['label' => 'Are You Ready?', 'body' => 'To start your life in Spain, whether in a city on the peninsula, or in Ibiza or one of the other Spanish islands.'],
    ]);
@endphp
@if($section?->is_active)
<section class="bg-opacity-25 bg-blue-25 text-white pt-16">
    <div class="houzez-container border border-white">
        <div class="grid grid-cols-1 md:grid-cols-3 md:divide-x">
            @foreach ($pillars as $i => $pillar)
                <div class="reveal reveal-delay-{{ $i + 1 }} px-8 py-12 text-center md:px-10 md:py-14">
                    <span class="mb-5 block font-sans text-[24px] font-bold uppercase tracking-[0.22em] text-white/75">{{ $section?->extraTrans("pillars.{$i}.label") ?? $pillar['label'] }}</span>
                    <p class="mx-auto max-w-xs font-sans text-[15px] leading-[1.8] text-white/85">{{ $section?->extraTrans("pillars.{$i}.body") ?? $pillar['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
