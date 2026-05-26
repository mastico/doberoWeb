@if($section?->is_active)
<section class="bg-light section-shell">
    <div class="houzez-container">
        <div class="grid items-start gap-12 lg:grid-cols-2">

            {{-- Left: text + contact details --}}
            <div class="reveal">
                <h2 class="section-heading">
                    {{ $section?->title ?? 'Please Write To Us' }}
                </h2>
                <p class="mt-5 section-body">
                    {{ $section?->content ?? 'If you are looking for a property or if you need any refurbishment, get in touch. A team member replies within one business day.' }}
                </p>

                <ul class="mt-8 space-y-4">
                    <li class="flex items-start gap-3 font-sans text-[14px] text-muted">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        <span>{{ \App\Models\SiteSetting::get('address', 'Costa Blanca, Spain') }}</span>
                    </li>
                    <li class="flex items-center gap-3 font-sans text-[14px] text-muted">
                        <svg class="h-5 w-5 shrink-0 text-primary" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                        </svg>
                        <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                           class="hover:text-primary transition-colors">
                            {{ \App\Models\SiteSetting::get('phone', '+1 (800) 990 8877') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3 font-sans text-[14px] text-muted">
                        <svg class="h-5 w-5 shrink-0 text-primary" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                        </svg>
                        <a href="mailto:{{ \App\Models\SiteSetting::get('email', 'info@dobero.es') }}"
                           class="hover:text-primary transition-colors">
                            {{ \App\Models\SiteSetting::get('email', 'info@dobero.es') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Right: form --}}
            <div class="reveal reveal-delay-2">
                <div class="bg-white border border-[#dce0e0] p-8 shadow-card">
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </div>
</section>
@endif
