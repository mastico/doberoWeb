<x-layouts.app :title="__('Construction')" :description="__('Full and partial renovations, turnkey construction. Quality is not an option — it is a principle.')">

    {{-- Header banner --}}
    <section class="bg-[#6b8fa8] pt-32 pb-12">
        <div class="houzez-container">
            <p class="font-sans text-[12px] uppercase tracking-widest text-white/60 mb-2">DOBERO</p>
            <h1 class="font-sans text-[2rem] font-light text-white">{{ __('Construction') }}</h1>
            <p class="mt-2 font-sans text-[14px] text-white/75">{{ __('Full and partial renovations, turnkey construction. Quality is not an option — it is a principle.') }}</p>
        </div>
    </section>

    {{-- Main layout: sticky sidebar + content --}}
    <div class="bg-white">
        <div class="houzez-container py-14">
            <div class="flex gap-12 items-start">

                {{-- Sticky sidebar with scroll-spy --}}
                <aside
                    class="hidden lg:block w-56 shrink-0 sticky top-24 self-start max-h-[calc(100vh-7rem)] overflow-y-auto"
                    x-data="{
                        active: 'general-construction',
                        sections: ['general-construction','refurbishment','permit-acquisition','references'],
                        onScroll() {
                            const offset = 160;
                            let current = this.sections[0];
                            for (const id of this.sections) {
                                const el = document.getElementById(id);
                                if (el && el.getBoundingClientRect().top <= offset) {
                                    current = id;
                                }
                            }
                            this.active = current;
                        }
                    }"
                    @scroll.window="onScroll()"
                    x-init="onScroll()"
                >
                    <p class="font-sans text-[11px] uppercase tracking-widest font-semibold text-muted mb-4">{{ __('Quick Navigation') }}</p>
                    <nav class="space-y-1">
                        @foreach([
                            ['general-construction', __('General Construction')],
                            ['refurbishment',         __('Refurbishment')],
                            ['permit-acquisition',    __('Permit Acquisition')],
                            ['references',            __('References')],
                        ] as [$id, $label])
                            <a href="#{{ $id }}"
                               :class="active === '{{ $id }}'
                                   ? 'bg-[#eaf3fa] text-dobero-blue font-semibold'
                                   : 'text-body hover:bg-[#f0f4f7] hover:text-navy'"
                               class="flex items-center gap-2 rounded-md px-3 py-2 font-sans text-[13px] transition-colors">
                                <span class="h-1.5 w-1.5 rounded-full bg-dobero-blue shrink-0 transition-opacity"
                                      :class="active === '{{ $id }}' ? 'opacity-100' : 'opacity-0'"></span>
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                {{-- Content sections --}}
                <div class="flex-1 min-w-0 space-y-0">

                    {{-- 1. General Construction --}}
                    <section id="general-construction" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/>'
                            :title="__('General Construction')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('When our clients commission full general construction from us, we take over the entire process from planning to turnkey handover.') }}</p>

                            <h3>{{ __('1. Condition Assessment & Planning') }}</h3>
                            <p>{{ __('We start with a detailed technical survey, then align with the client\'s needs, style and budget. Where needed we prepare interior design and technical plans, and optimise the property layout.') }}</p>

                            <h3>{{ __('2. Permits & Administration') }}</h3>
                            <p>{{ __('We handle all required municipal permits, notifications and official procedures. We liaise with local authorities and utility providers throughout.') }}</p>

                            <h3>{{ __('3. Demolition & Structural Works') }}</h3>
                            <p>{{ __('We carry out demolition, wall relocation, floor-plan alterations and, where required, structural reinforcements — all based on structural and technical assessments.') }}</p>

                            <h3>{{ __('4. Mechanical & Electrical Systems') }}</h3>
                            <p>{{ __('Full water, drainage and electrical network renovation or replacement. We install air conditioning, underfloor heating, heat pumps or energy-efficient systems.') }}</p>

                            <h3>{{ __('5. Insulation & Energy Improvements') }}</h3>
                            <p>{{ __('Waterproofing, thermal insulation, roof and terrace insulation. Our goal is low running costs and long-term value retention.') }}</p>

                            <h3>{{ __('6. Interior Works & Design') }}</h3>
                            <p>{{ __('Tiling, painting, window and door replacement, bespoke kitchens and bathrooms. Full furnishing and interior design available on request.') }}</p>

                            <h3>{{ __('7. Exterior Works') }}</h3>
                            <p>{{ __('Facade renovation, terraces, pools, landscaping, fencing and parking areas.') }}</p>

                            <h3>{{ __('8. Project Management & Quality Control') }}</h3>
                            <p>{{ __('The entire construction is personally supervised. We provide continuous communication with regular reports and photo documentation, especially for clients living abroad.') }}</p>

                            <h3>{{ __('9. Turnkey Handover') }}</h3>
                            <p>{{ __('At the end of the works we carry out a technical handover with a checklist and warranty documentation. Our client receives a fully finished property, ready to occupy or let immediately.') }}</p>

                            <p class="font-medium">{{ __('Our goal is for our clients to experience the renovation process as stress-free, transparent and safe — while significantly increasing the property\'s value.') }}</p>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 2. Refurbishment --}}
                    <section id="refurbishment" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l5.654-4.654m5.96-4.994.09-.09a1.15 1.15 0 0 1 1.497-.02L18 6.75l.985.986a1.25 1.25 0 0 1-.02 1.497l-.09.09m-6.23-6.23 1.5-1.5a2.121 2.121 0 0 1 3 3l-1.5 1.5"/>'
                            :title="__('Refurbishment')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('If our clients commission only a partial, smaller renovation — for example a full kitchen or bathroom upgrade on the Costa Blanca — we handle the process with the same precision as a full general construction project.') }}</p>
                            <p>{{ __('We assist with design and material selection, then carry out the demolition, mechanical, electrical and tiling works. If required, we can convert a bathroom from a bathtub to a walk-in shower, or vice versa. Old kitchens are transformed with custom-designed, high-quality furniture crafted by our experienced joiner.') }}</p>
                            <p>{{ __('We coordinate and supervise all works throughout, so our clients receive a fast, clean and professional result — with no hidden costs.') }}</p>
                        </div>
                        <x-relocation-note>{{ __('Whether it\'s a single room or the entire property, every project receives the same level of care, precision and personal supervision.') }}</x-relocation-note>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 3. Permit Acquisition --}}
                    <section id="permit-acquisition" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>'
                            :title="__('Permit Acquisition')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('Obtaining permits and required licences is our responsibility. We handle this based on our engineer\'s plans, strictly adhering to the town hall\'s regulations and requirements. All official documentation is meticulously prepared so you can be confident the project fully complies with local regulations.') }}</p>
                            <p>{{ __('Throughout our work we always strive for transparency and security, so you can entrust your property renovation to us with complete peace of mind. In addition to obtaining permits, we provide continuous professional support to ensure every step meets legal and technical requirements.') }}</p>
                        </div>
                        <x-relocation-note>{{ __('All permit procedures are managed by our engineer and handled directly with the town hall — you don\'t need to be present.') }}</x-relocation-note>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 4. References --}}
                    <section id="references" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>'
                            :title="__('References')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p class="text-body/60 italic">{{ __('Our project reference gallery is coming soon. Please contact us directly to learn more about our completed projects.') }}</p>
                        </div>
                        <x-relocation-note>{{ __('Contact us for a free consultation and tailored quote for your renovation project on the Costa Blanca.') }}</x-relocation-note>
                    </section>

                </div>{{-- end content --}}
            </div>
        </div>
    </div>

</x-layouts.app>
