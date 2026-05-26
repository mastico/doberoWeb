<x-layouts.app :title="__('Special Services')" :description="__('Expert property inspection, hidden defect investigation, waterproofing and forensic support on the Costa Blanca.')">

    {{-- Header banner --}}
    <section class="bg-[#6b8fa8] pt-32 pb-12">
        <div class="houzez-container">
            <p class="font-sans text-[12px] uppercase tracking-widest text-white/60 mb-2">DOBERO</p>
            <h1 class="font-sans text-[2rem] font-light text-white">{{ __('Special Services') }}</h1>
            <p class="mt-2 font-sans text-[14px] text-white/75">{{ __('Expert property inspection, hidden defect investigation, waterproofing and forensic support on the Costa Blanca.') }}</p>
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
                        active: 'assessment',
                        sections: ['assessment','hidden-defects','waterproofing','forensics'],
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
                            ['assessment',    __('Technical Condition Assessment')],
                            ['hidden-defects',__('Discovery of Hidden Defects')],
                            ['waterproofing', __('Waterproofing Solutions')],
                            ['forensics',     __('Forensic Expert Support')],
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

                    {{-- 1. Technical Condition Assessment --}}
                    <section id="assessment" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.185-1.98-2.241a48.424 48.424 0 0 0-6.52-.088m-5.292.06A48.47 48.47 0 0 0 3.73 3.867C2.595 3.921 1.75 4.971 1.75 6.106V19.5A2.25 2.25 0 0 0 4 21.75h.75"/>'
                            :title="__('Technical Property Survey Before Purchase')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('Before purchasing a property, I provide a comprehensive technical survey, which I personally coordinate with trusted professionals. We thoroughly examine the structural condition, mechanical systems, moisture issues, and any potential renovation risks.') }}</p>
                            <p>{{ __('My aim is to ensure that my client has a clear understanding of possible future costs and hidden risks. A detailed and easy-to-understand report is provided following the inspection. This allows you to make a safe and well-informed decision before buying.') }}</p>

                            <h3>{{ __('What we examine') }}</h3>
                            <ul>
                                <li>{{ __('Structural condition of walls, ceilings and foundations') }}</li>
                                <li>{{ __('Plumbing, drainage and electrical systems') }}</li>
                                <li>{{ __('Moisture levels and signs of water ingress') }}</li>
                                <li>{{ __('Roof and terrace waterproofing integrity') }}</li>
                                <li>{{ __('Quality and condition of windows, doors and insulation') }}</li>
                                <li>{{ __('Estimated renovation costs and risk areas') }}</li>
                            </ul>
                        </div>
                        <x-relocation-note>{{ __('The inspection report is provided in writing in your language, with photos and cost estimates — giving you full clarity before signing.') }}</x-relocation-note>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 2. Hidden Defects --}}
                    <section id="hidden-defects" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>'
                            :title="__('Identification of Hidden Defects')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('Beyond visible issues, I place strong emphasis on identifying hidden defects. Drawing on my experience and working with specialist partners, we investigate structural cracks, damp problems, insulation deficiencies, and previously poorly executed repairs.') }}</p>
                            <p>{{ __('These issues are often not visible at first glance but can lead to significant expenses later. My goal is to prevent unpleasant surprises after completion. All findings are properly documented and clearly explained to the client.') }}</p>

                            <h3>{{ __('Common hidden defects we uncover') }}</h3>
                            <ul>
                                <li>{{ __('Structural cracks concealed behind plaster or paint') }}</li>
                                <li>{{ __('Water ingress from roofs, terraces or external walls') }}</li>
                                <li>{{ __('Substandard or non-compliant electrical installations') }}</li>
                                <li>{{ __('Poorly insulated or unventilated spaces') }}</li>
                                <li>{{ __('Previous repairs carried out without proper permits') }}</li>
                            </ul>
                        </div>
                        <x-relocation-note>{{ __('Many defects are intentionally hidden by sellers. An independent survey protects your investment and your negotiating position.') }}</x-relocation-note>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 3. Waterproofing --}}
                    <section id="waterproofing" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c-1.2 5.4-6 7.8-6 12a6 6 0 0 0 12 0c0-4.2-4.8-6.6-6-12Z"/>'
                            :title="__('Waterproofing Solutions')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('Due to the climate in the Costa Blanca region, damp and water ingress can be common problems. Together with my own team, I provide professional waterproofing solutions for roofs, terraces, basements, and walls.') }}</p>
                            <p>{{ __('We use modern materials and proven technologies to ensure long-term protection. I personally supervise each project to guarantee high standards of workmanship. Our objective is to preserve and enhance the value of your property.') }}</p>

                            <h3>{{ __('Areas we waterproof') }}</h3>
                            <ul>
                                <li>{{ __('Flat roofs and pitched roof membranes') }}</li>
                                <li>{{ __('Terraces, balconies and outdoor surfaces') }}</li>
                                <li>{{ __('Basements and below-grade walls') }}</li>
                                <li>{{ __('Wet rooms — bathrooms and kitchens') }}</li>
                                <li>{{ __('External facade coatings') }}</li>
                            </ul>
                        </div>
                        <x-relocation-note>{{ __('All waterproofing work comes with a guarantee and uses materials rated for the Mediterranean climate.') }}</x-relocation-note>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 4. Forensic Expert Support --}}
                    <section id="forensics" class="scroll-mt-16">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>'
                            :title="__('Court Expert Support')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{{ __('If a seller has concealed relevant defects or information during the sale, we provide court expert support. Together with my certified expert colleague, we prepare an official technical report regarding the identified issues.') }}</p>
                            <p>{{ __('All necessary technical evidence is professionally documented and suitable for use in legal proceedings. We firmly represent our clients\' interests in dispute situations. Our aim is to ensure that buyers receive full professional and legal protection.') }}</p>

                            <h3>{{ __('What the expert report covers') }}</h3>
                            <ul>
                                <li>{{ __('Official written assessment of structural and technical defects') }}</li>
                                <li>{{ __('Photo and video documentation of all findings') }}</li>
                                <li>{{ __('Estimated cost of damage and required remediation') }}</li>
                                <li>{{ __('Statement on whether defects were pre-existing and concealed') }}</li>
                                <li>{{ __('Document package suitable for court or legal proceedings') }}</li>
                            </ul>
                        </div>
                        <x-relocation-note>{{ __('Our forensic expert reports are admissible in Spanish courts and can support claims for compensation or contract rescission.') }}</x-relocation-note>
                    </section>

                </div>{{-- end content --}}
            </div>
        </div>
    </div>

</x-layouts.app>
