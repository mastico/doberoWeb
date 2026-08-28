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
                        sections: ['assessment','hidden-defects','waterproofing','forensics','residency-assistance','technical-property-inspection','real-estate-brokerage','mortgage-assistance','renovation-remodeling','electrical-compliance','thermal-acoustic-insulation','project-management','building-rehabilitation','rope-access-vertical-works','hidden-defect-inspection','building-pathology','expert-witness-legal','energy-performance-certificate','solar-panel-installation','terrace-enclosure'],
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
                            ['residency-assistance',      __('Residency Assistance (Costa Blanca)')],
                            ['technical-property-inspection', __('Technical Property Inspection')],
                            ['real-estate-brokerage',     __('Real Estate Brokerage')],
                            ['mortgage-assistance',       __('Mortgage Assistance')],
                            ['renovation-remodeling',     __('Renovation and Remodeling')],
                            ['electrical-compliance',     __('Electrical Compliance Certificate (Boletín)')],
                            ['thermal-acoustic-insulation', __('Thermal and Acoustic Insulation')],
                            ['project-management',        __('Project Management')],
                            ['building-rehabilitation',   __('Building Rehabilitation')],
                            ['rope-access-vertical-works', __('Rope Access / Vertical Works')],
                            ['hidden-defect-inspection',  __('Hidden Defect Inspection')],
                            ['building-pathology',        __('Building Pathology')],
                            ['expert-witness-legal',      __('Expert Witness and Technical Support for Legal Proceedings')],
                            ['energy-performance-certificate', __('Energy Performance Certificate (EPC)')],
                            ['solar-panel-installation',  __('Solar Panel System Installation')],
                            ['terrace-enclosure',         __('Terrace Enclosure (with Aluminium Frames and Sandwich Panels)')],
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

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 5. Residency Assistance --}}
                     <section id="residency-assistance" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3"/>'
                             :title="__('Residency Assistance (Costa Blanca)')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('We assist clients with residency matters on the Costa Blanca, providing comprehensive support through every step of the process. Whether you require assistance with documentation, official procedures, or liaising with local authorities, we are here to simplify your relocation journey.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 6. Technical Property Inspection --}}
                     <section id="technical-property-inspection" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.185-1.98-2.241a48.424 48.424 0 0 0-6.52-.088m-5.292.06A48.47 48.47 0 0 0 3.73 3.867C2.595 3.921 1.75 4.971 1.75 6.106V19.5A2.25 2.25 0 0 0 4 21.75h.75"/>'
                             :title="__('Technical Property Inspection')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Before purchasing a property, a thorough technical inspection is essential. We provide comprehensive inspections before purchase, examining every aspect of the property to ensure you make an informed decision.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 7. Real Estate Brokerage --}}
                     <section id="real-estate-brokerage" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0-9.75h-6a2.25 2.25 0 0 0-2.25 2.25v6.75H3a.75.75 0 0 1-.75-.75V3a.75.75 0 0 1 .75-.75h6.75A.75.75 0 0 1 9 3v18"/>'
                             :title="__('Real Estate Brokerage')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Our real estate brokerage services connect buyers with quality properties on the Costa Blanca, offering expert guidance throughout the acquisition process.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 8. Mortgage Assistance --}}
                     <section id="mortgage-assistance" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 3.071-.879 4.242 0M9.75 11.25c.386 0 .75-.277.75-.618v-2.764c0-.341-.364-.618-.75-.618s-.75.277-.75.618v2.764c0 .341.364.618.75.618Zm0-6c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3Z"/>'
                             :title="__('Mortgage Assistance')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('We provide comprehensive mortgage assistance, helping clients navigate financing options and secure favorable terms for their property purchases on the Costa Blanca.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 9. Renovation and Remodeling --}}
                     <section id="renovation-remodeling" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.5v2.25m6-2.25v2.25m0-9L5.25 7.5m15 0l-15 0"/>'
                             :title="__('Renovation and Remodeling')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Full and partial renovations tailored to your needs. We handle everything from design to completion, ensuring quality workmanship and transparent communication throughout the project.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 10. Electrical Compliance Certificate --}}
                     <section id="electrical-compliance" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.87 6.573A7.125 7.125 0 0 0 3 12m0 0A7.125 7.125 0 0 0 9.87 17.427M3 12l6.873-6.427m0 12.854L3 12m9-2.812A2.25 2.25 0 1 1 12 12a2.25 2.25 0 0 1 0-2.812m0 0h.008v.008H12v-.008Z"/>'
                             :title="__('Electrical Compliance Certificate (Boletín)')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('We arrange electrical compliance certificates (Boletín) ensuring your property meets Spanish electrical safety standards. This document is essential for property sales and regulatory compliance.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 11. Thermal and Acoustic Insulation --}}
                     <section id="thermal-acoustic-insulation" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-9v9m0 0l-3-3m3 3l3-3"/>'
                             :title="__('Thermal and Acoustic Insulation')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Improve comfort and energy efficiency with professional thermal and acoustic insulation solutions. We provide superior insulation for walls, roofs, and floors to reduce energy costs and noise levels.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 12. Project Management --}}
                     <section id="project-management" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 6.75V15m6-6V15M3 12.75A6.75 6.75 0 1 1 15.75 6m-9 15h12a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25v12a2.25 2.25 0 0 0 2.25 2.25Z"/>'
                             :title="__('Project Management')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Expert project management ensuring your renovation stays on schedule and within budget. We coordinate all trades, handle logistics, and maintain transparent communication with regular updates and documentation.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 13. Building Rehabilitation --}}
                     <section id="building-rehabilitation" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m-5.325-1.275a6.447 6.447 0 0 0 2.6-.545m0 0a6.44 6.44 0 0 0 2.6.545m-5.2-8.788a11.952 11.952 0 0 0 1.173-2.882m2.054 2.882a11.952 11.952 0 0 1 1.173 2.882m-16.39 0a37.5 37.5 0 0 0 2.514-10.542m10.772 13.01A5.25 5.25 0 0 1 9 18.75"/>'
                             :title="__('Building Rehabilitation')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Comprehensive building rehabilitation services restoring aging properties to modern standards. We handle structural repairs, system upgrades, and aesthetic improvements to breathe new life into your property.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 14. Rope Access / Vertical Works --}}
                     <section id="rope-access-vertical-works" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3v1.5M3 16.5v2m18-2v2m0-21v-1.5M9 6.75h1.5M15 6.75h1.5M21 19.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM4.5 19.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>'
                             :title="__('Rope Access / Vertical Works')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Specialized rope access services for high-rise building maintenance, repairs, and installations. Our certified professionals handle challenging vertical work safely and efficiently.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 15. Hidden Defect Inspection --}}
                     <section id="hidden-defect-inspection" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>'
                             :title="__('Hidden Defect Inspection')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Thorough inspections uncovering hidden defects that may not be immediately visible. Using specialized techniques and expertise, we identify issues before they become costly problems.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 16. Building Pathology --}}
                     <section id="building-pathology" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75l6 6 9-13.5"/>'
                             :title="__('Building Pathology')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Expert analysis of building degradation and disease. We diagnose structural and material failures, providing scientific assessment and remediation recommendations.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 17. Expert Witness and Legal Support --}}
                     <section id="expert-witness-legal" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 3.071-.879 4.242 0M9.75 11.25c.386 0 .75-.277.75-.618v-2.764c0-.341-.364-.618-.75-.618s-.75.277-.75.618v2.764c0 .341.364.618.75.618Z"/>'
                             :title="__('Expert Witness and Technical Support for Legal Proceedings')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Professional expert witness services for legal disputes. We prepare comprehensive technical reports and provide testimony to support property-related claims in court.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 18. Energy Performance Certificate --}}
                     <section id="energy-performance-certificate" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h2.25C11.496 10.5 12 11.004 12 11.625v-3c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v7.125M9 16.5v5.25m-4.5-15H5.625m13.5 2.236A4.973 4.973 0 0 1 16.5 20.25H7.5A4.972 4.972 0 0 1 3.375 5.414M9 9h.008v.008H9V9Z"/>'
                             :title="__('Energy Performance Certificate (EPC)')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('We arrange Energy Performance Certificates (EPC) required for property sales and rentals. These certificates assess energy efficiency and provide recommendations for improvements.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 19. Solar Panel Installation --}}
                     <section id="solar-panel-installation" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-9v9m0 0l-3-3m3 3l3-3"/>'
                             :title="__('Solar Panel System Installation')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Professional solar panel system installation to harness renewable energy. We handle everything from design and permits to installation and maintenance of photovoltaic systems.') }}</p>
                         </div>
                     </section>

                     <hr class="border-[#e8ecf0] my-8">

                     {{-- 20. Terrace Enclosure --}}
                     <section id="terrace-enclosure" class="scroll-mt-16">
                         <x-relocation-section-header
                             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21M4.5 8.625h15M4.5 12h15m-15 3.375h15"/>'
                             :title="__('Terrace Enclosure (with Aluminium Frames and Sandwich Panels)')"
                         />
                         <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                             <p>{{ __('Transform your outdoor terrace with professional enclosure services. We install premium aluminium frames with sandwich panels, creating a weatherproof and thermally efficient space.') }}</p>
                         </div>
                     </section>

                 </div>{{-- end content --}}
            </div>
        </div>
    </div>

</x-layouts.app>
