@php
    if (\Illuminate\Support\Facades\Schema::hasTable('nav_items')) {
        $primary = \App\Models\NavItem::roots()
            ->location('primary')
            ->active()
            ->ordered()
            ->with(['children' => fn ($query) => $query->active()->ordered()])
            ->get()
            ->reject(function (\App\Models\NavItem $item): bool {
                $legacySpecialsChildren = [
                    'Technical Condition Assessment',
                    'Discovery of Hidden Defects',
                    'Waterproofing Solutions',
                    'Forensic Expert Support',
                ];

                return $item->getTranslation('label', 'en', false) === 'Specials'
                    && $item->children
                        ->map(fn (\App\Models\NavItem $child) => $child->getTranslation('label', 'en', false))
                        ->sort()
                        ->values()
                        ->all() === collect($legacySpecialsChildren)->sort()->values()->all();
            });
    } else {
        $primary = collect();
    }
@endphp

@php $isHome = request()->routeIs('home', '*.home'); @endphp
<header
    x-data="{ scrolled: false, open: false, active: null }"
    @scroll.window="scrolled = window.scrollY > 60"
    @keydown.escape.window="active = null; open = false"
    :class="scrolled ? 'bg-navy shadow-editorial' : '{{ $isHome ? 'bg-transparent' : 'bg-navy' }}'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
>
    @if ($isHome)
        <div :class="scrolled ? 'h-0 overflow-hidden opacity-0' : 'h-9 opacity-100'"
             class="bg-navy/90 border-b border-white/10 transition-all duration-300">
            <div class="houzez-container flex h-9 items-center justify-between">
                <span class="font-body text-[13px] font-light text-white/65">Costa Blanca · Spain</span>
                <div class="flex items-center gap-4 font-body text-[13px] font-light text-white/65">
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone', '+18009908877') }}" class="hover:text-primary transition-colors">
                        {{ \App\Models\SiteSetting::get('phone', '+1 (800) 990 8877') }}
                    </a>
                    <span class="hidden h-3 w-px bg-white/20 md:block"></span>
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email', 'info@dobero.es') }}" class="hidden hover:text-primary transition-colors md:block">
                        {{ \App\Models\SiteSetting::get('email', 'info@dobero.es') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="houzez-container flex h-[68px] items-center justify-between">
        <a href="{{ route('home') }}" class="shrink-0">
            <img src="{{ asset('images/logo-white.png') }}" alt="DOBERO" class="h-12 w-auto object-contain">
        </a>

        <nav class="hidden items-center lg:flex">
            <a href="{{ route('home') }}" class="nav-link px-3 py-2">HOME</a>

            @foreach ($primary as $item)
                <div class="relative" @mouseenter="active = '{{ $item->label }}'" @mouseleave="active = null">
                    <a href="{{ $item->url }}" class="nav-link px-3 py-2 inline-flex items-center gap-1" @if($item->opens_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                        {{ strtoupper($item->label) }}
                        @if ($item->children->isNotEmpty())
                            <svg class="w-2.5 h-2.5 opacity-50" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1.5L6 6.5L11 1.5"/></svg>
                        @endif
                    </a>

                    @if ($item->children->isNotEmpty())
                        <div x-cloak x-show="active === '{{ $item->label }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-1/2 -translate-x-1/2 top-full pt-2 z-50">
                            <div class="nav-dropdown-inner">
                                @foreach ($item->children as $child)
                                    <a href="{{ $child->url }}" class="nav-dropdown-item" @if($child->opens_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                        {{ $child->label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Specials Dropdown --}}
            <div class="relative" @mouseenter="active = 'Specials'" @mouseleave="active = null">
                <a href="{{ route('specials') }}" class="nav-link px-3 py-2 inline-flex items-center gap-1">
                    {{ strtoupper(__('Specials')) }}
                    <svg class="w-2.5 h-2.5 opacity-50" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1.5L6 6.5L11 1.5"/></svg>
                </a>

                <div x-cloak x-show="active === 'Specials'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-1/2 -translate-x-1/2 top-full pt-2 z-50">
                    <div class="nav-dropdown-inner">
                        <a href="#residency-assistance" class="nav-dropdown-item">{{ __('Residency Assistance (Costa Blanca)') }}</a>
                        <a href="#technical-property-inspection" class="nav-dropdown-item">{{ __('Technical Property Inspection') }}</a>
                        <a href="#real-estate-brokerage" class="nav-dropdown-item">{{ __('Real Estate Brokerage') }}</a>
                        <a href="#mortgage-assistance" class="nav-dropdown-item">{{ __('Mortgage Assistance') }}</a>
                        <a href="#renovation-remodeling" class="nav-dropdown-item">{{ __('Renovation and Remodeling') }}</a>
                        <a href="#electrical-compliance" class="nav-dropdown-item">{{ __('Electrical Compliance Certificate (Boletín)') }}</a>
                        <a href="#thermal-acoustic-insulation" class="nav-dropdown-item">{{ __('Thermal and Acoustic Insulation') }}</a>
                        <a href="#project-management" class="nav-dropdown-item">{{ __('Project Management') }}</a>
                        <a href="#building-rehabilitation" class="nav-dropdown-item">{{ __('Building Rehabilitation') }}</a>
                        <a href="#rope-access-vertical-works" class="nav-dropdown-item">{{ __('Rope Access / Vertical Works') }}</a>
                        <a href="#hidden-defect-inspection" class="nav-dropdown-item">{{ __('Hidden Defect Inspection') }}</a>
                        <a href="#building-pathology" class="nav-dropdown-item">{{ __('Building Pathology') }}</a>
                        <a href="#expert-witness-legal" class="nav-dropdown-item">{{ __('Expert Witness and Technical Support for Legal Proceedings') }}</a>
                        <a href="#energy-performance-certificate" class="nav-dropdown-item">{{ __('Energy Performance Certificate (EPC)') }}</a>
                        <a href="#solar-panel-installation" class="nav-dropdown-item">{{ __('Solar Panel System Installation') }}</a>
                        <a href="#terrace-enclosure" class="nav-dropdown-item">{{ __('Terrace Enclosure (with Aluminium Frames and Sandwich Panels)') }}</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('contact') }}" class="nav-link px-3 py-2">{{ strtoupper(__('Contact Us')) }}</a>
        </nav>

        <div class="hidden items-center gap-5 lg:flex">
            @php $currentLocale = app()->getLocale(); @endphp
            <div class="relative" x-data="{ langOpen: false }" @mouseleave="langOpen = false">
                <button @mouseenter="langOpen = true" @click="langOpen = !langOpen" class="flex items-center gap-1.5 font-nav text-[12px] uppercase tracking-nav text-white/75 hover:text-primary transition-colors" aria-label="{{ __('Language') }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"/></svg>
                    {{ available_locales()[$currentLocale]['short'] ?? strtoupper($currentLocale) }}
                </button>
                <div x-cloak x-show="langOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="absolute right-0 top-full pt-2 z-50">
                    <div class="nav-dropdown-inner min-w-[140px]">
                        @foreach (available_locales() as $code => $info)
                            <a href="{{ switch_locale_url($code) }}" class="nav-dropdown-item {{ $code === $currentLocale ? 'font-semibold text-primary' : '' }}">
                                {{ $info['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <button @click="open = !open" class="inline-flex h-10 w-10 items-center justify-center text-white lg:hidden" aria-label="Open menu">
            <svg x-show="!open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M3 6h18M3 12h18M3 18h18"/></svg>
            <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M6 6l12 12M6 18L18 6"/></svg>
        </button>
    </div>

    <div x-cloak x-show="open" x-transition class="border-t border-white/10 bg-navy lg:hidden">
        <div class="houzez-container py-4">
            <a href="{{ route('home') }}" class="block border-b border-white/10 py-3 font-nav text-[13px] uppercase tracking-nav text-white/80">Home</a>
            @foreach ($primary as $item)
                <details class="border-b border-white/10">
                    <summary class="flex cursor-pointer list-none items-center justify-between py-3 font-nav text-[13px] uppercase tracking-nav text-white/80">
                        <span>{{ $item->label }}</span>
                        @if ($item->children->isNotEmpty())<span class="text-primary">+</span>@endif
                    </summary>
                    @if ($item->children->isNotEmpty())
                        <div class="space-y-1 pb-3 pl-4">
                            @foreach ($item->children as $child)
                                <a href="{{ $child->url }}" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors" @if($child->opens_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </details>
            @endforeach

            {{-- Specials Dropdown (Mobile) --}}
            <details class="border-b border-white/10">
                <summary class="flex cursor-pointer list-none items-center justify-between py-3 font-nav text-[13px] uppercase tracking-nav text-white/80">
                    <span>{{ __('Specials') }}</span>
                    <span class="text-primary">+</span>
                </summary>
                <div class="space-y-1 pb-3 pl-4">
                    <a href="{{ route('specials') }}#residency-assistance" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Residency Assistance (Costa Blanca)') }}</a>
                    <a href="{{ route('specials') }}#technical-property-inspection" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Technical Property Inspection') }}</a>
                    <a href="{{ route('specials') }}#real-estate-brokerage" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Real Estate Brokerage') }}</a>
                    <a href="{{ route('specials') }}#mortgage-assistance" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Mortgage Assistance') }}</a>
                    <a href="{{ route('specials') }}#renovation-remodeling" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Renovation and Remodeling') }}</a>
                    <a href="{{ route('specials') }}#electrical-compliance" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Electrical Compliance Certificate (Boletín)') }}</a>
                    <a href="{{ route('specials') }}#thermal-acoustic-insulation" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Thermal and Acoustic Insulation') }}</a>
                    <a href="{{ route('specials') }}#project-management" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Project Management') }}</a>
                    <a href="{{ route('specials') }}#building-rehabilitation" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Building Rehabilitation') }}</a>
                    <a href="{{ route('specials') }}#rope-access-vertical-works" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Rope Access / Vertical Works') }}</a>
                    <a href="{{ route('specials') }}#hidden-defect-inspection" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Hidden Defect Inspection') }}</a>
                    <a href="{{ route('specials') }}#building-pathology" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Building Pathology') }}</a>
                    <a href="{{ route('specials') }}#expert-witness-legal" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Expert Witness and Technical Support for Legal Proceedings') }}</a>
                    <a href="{{ route('specials') }}#energy-performance-certificate" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Energy Performance Certificate (EPC)') }}</a>
                    <a href="{{ route('specials') }}#solar-panel-installation" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Solar Panel System Installation') }}</a>
                    <a href="{{ route('specials') }}#terrace-enclosure" class="block py-2 font-sans text-[13px] text-white/65 hover:text-primary transition-colors">{{ __('Terrace Enclosure (with Aluminium Frames and Sandwich Panels)') }}</a>
                </div>
            </details>

            <a href="{{ route('contact') }}" class="block py-3 font-nav text-[13px] uppercase tracking-nav text-white/80">{{ __('Contact Us') }}</a>

            @php $currentLocale = app()->getLocale(); @endphp
            <div class="mt-2 border-t border-white/10 pt-3">
                <span class="block pb-2 font-nav text-[11px] uppercase tracking-nav text-white/40">{{ __('Language') }}</span>
                <div class="flex flex-wrap gap-2">
                    @foreach (available_locales() as $code => $info)
                        <a href="{{ switch_locale_url($code) }}" class="px-3 py-1.5 font-nav text-[12px] uppercase tracking-nav transition-colors {{ $code === $currentLocale ? 'bg-primary text-white' : 'border border-white/20 text-white/70 hover:bg-white/10' }}">
                            {{ $info['short'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>
