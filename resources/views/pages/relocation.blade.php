<x-layouts.app :title="trans('relocation.title')" :description="trans('relocation.description')">
<x-seo.faq-schema page="relocation" />

    {{-- Header banner --}}
    <section class="bg-[#6b8fa8] pt-32 pb-12">
        <div class="houzez-container">
            <p class="font-sans text-[12px] uppercase tracking-widest text-white/60 mb-2">{{ trans('relocation.subtitle') }}</p>
            <h1 class="font-sans text-[2rem] font-light text-white">{{ trans('relocation.title') }}</h1>
            <p class="mt-2 font-sans text-[14px] text-white/75">{{ trans('relocation.description') }}</p>
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
                        active: 'notary',
                        sections: ['notary','nie','bank','address','residency','digital-signature','transcript'],
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
                    <p class="font-sans text-[11px] uppercase tracking-widest font-semibold text-muted mb-4">{{ trans('relocation.nav_label') }}</p>
                    <nav class="space-y-1">
                        @foreach(['notary','nie','bank','address','residency','digital-signature','transcript'] as $id)
                            <a href="#{{ $id }}"
                               :class="active === '{{ $id }}'
                                   ? 'bg-[#eaf3fa] text-dobero-blue font-semibold'
                                   : 'text-body hover:bg-[#f0f4f7] hover:text-navy'"
                               class="flex items-center gap-2 rounded-md px-3 py-2 font-sans text-[13px] transition-colors">
                                <span class="h-1.5 w-1.5 rounded-full bg-dobero-blue shrink-0 transition-opacity"
                                      :class="active === '{{ $id }}' ? 'opacity-100' : 'opacity-0'"></span>
                                {{ trans('relocation.nav.'.$id) }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                {{-- Content sections --}}
                <div class="flex-1 min-w-0 space-y-0">

                    {{-- 1. Power of Attorney --}}
                    <section id="notary" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.185-1.98-2.241a48.424 48.424 0 0 0-6.52-.088m-5.292.06A48.47 48.47 0 0 0 3.73 3.867C2.595 3.921 1.75 4.971 1.75 6.106V19.5A2.25 2.25 0 0 0 4 21.75h.75"/>'
                            :title="trans('relocation.notary.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.notary.intro') !!}</p>
                            <h4>{{ trans('relocation.notary.h_uses') }}</h4>
                            <ul>@foreach(trans('relocation.notary.uses') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.notary.h_actions') }}</h4>
                            <ul>@foreach(trans('relocation.notary.actions') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <x-relocation-note>{{ trans('relocation.notary.note') }}</x-relocation-note>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 2. NIE Number --}}
                    <section id="nie" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>'
                            :title="trans('relocation.nie.title')"
                            :badge="trans('relocation.nie.badge')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.nie.intro') !!}</p>
                            <h4>{{ trans('relocation.nie.h_uses') }}</h4>
                            <ul>@foreach(trans('relocation.nie.uses') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <x-relocation-note>{{ trans('relocation.nie.note') }}</x-relocation-note>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 3. Opening Bank Account --}}
                    <section id="bank" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>'
                            :title="trans('relocation.bank.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.bank.intro') !!}</p>
                            <h4>{{ trans('relocation.bank.h_uses') }}</h4>
                            <ul>@foreach(trans('relocation.bank.uses') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.bank.h_important') }}</h4>
                            <ul>@foreach(trans('relocation.bank.important') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 4. Empadronamiento --}}
                    <section id="address" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819"/>'
                            :title="trans('relocation.address.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.address.intro') !!}</p>
                            <h4>{{ trans('relocation.address.h_required') }}</h4>
                            <ul>@foreach(trans('relocation.address.required') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.address.h_how') }}</h4>
                            <ol>@foreach(trans('relocation.address.how') as $item)<li>{!! $item !!}</li>@endforeach</ol>
                            <x-relocation-note>{{ trans('relocation.address.note') }}</x-relocation-note>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 5. European Residence --}}
                    <section id="residency" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>'
                            :title="trans('relocation.residency.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.residency.intro') !!}</p>
                            <h4>{{ trans('relocation.residency.h_enables') }}</h4>
                            <ul>@foreach(trans('relocation.residency.enables') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.residency.h_mandatory') }}</h4>
                            <p>{!! trans('relocation.residency.mandatory') !!}</p>
                            <h4>{{ trans('relocation.residency.h_docs') }}</h4>
                            <ul>@foreach(trans('relocation.residency.docs') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <x-relocation-note>{{ trans('relocation.residency.note') }}</x-relocation-note>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 6. Digital Signature --}}
                    <section id="digital-signature" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>'
                            :title="trans('relocation.digital_signature.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.digital_signature.intro') !!}</p>
                            <h4>{{ trans('relocation.digital_signature.h_uses') }}</h4>
                            <ul>@foreach(trans('relocation.digital_signature.uses') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.digital_signature.h_stored') }}</h4>
                            <ul>@foreach(trans('relocation.digital_signature.stored') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.digital_signature.h_managed') }}</h4>
                            <p>{!! trans('relocation.digital_signature.managed') !!}</p>
                            <x-relocation-note>{{ trans('relocation.digital_signature.note') }}</x-relocation-note>
                        </div>
                    </section>

                    <hr class="border-[#e8ecf0] my-8">

                    {{-- 7. Utility Transfer --}}
                    <section id="transcript" class="scroll-mt-36">
                        <x-relocation-section-header
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>'
                            :title="trans('relocation.transcript.title')"
                        />
                        <div class="mt-6 prose prose-sm max-w-none prose-headings:text-navy prose-headings:font-semibold prose-p:text-body prose-li:text-body prose-strong:text-navy">
                            <p>{!! trans('relocation.transcript.intro') !!}</p>
                            <h4>{{ trans('relocation.transcript.h_why') }}</h4>
                            <ul>@foreach(trans('relocation.transcript.why') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <h4>{{ trans('relocation.transcript.h_docs') }}</h4>
                            <ul>@foreach(trans('relocation.transcript.docs') as $item)<li>{!! $item !!}</li>@endforeach</ul>
                            <x-relocation-note>{{ trans('relocation.transcript.note') }}</x-relocation-note>
                        </div>
                    </section>

                </div>{{-- end content --}}
            </div>{{-- end flex --}}
        </div>{{-- end container --}}
    </div>

</x-layouts.app>
