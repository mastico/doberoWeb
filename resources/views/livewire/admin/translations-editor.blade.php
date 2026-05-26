<div class="flex gap-6 items-start">

    {{-- ── Left sidebar: group list ─────────────────────────────────────── --}}
    <aside class="w-52 shrink-0 rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Page Groups</p>
        </div>
        <nav class="py-2">
            @foreach ($this->groups as $groupName => $count)
                <button
                    type="button"
                    wire:click="$set('group', '{{ $groupName }}')"
                    class="w-full flex items-center justify-between px-5 py-2.5 text-sm transition-colors
                        {{ $group === $groupName
                            ? 'bg-navy/5 text-navy font-semibold'
                            : 'text-slate-600 hover:bg-slate-50' }}"
                >
                    <span class="capitalize">{{ str_replace('_', ' ', $groupName) }}</span>
                    <span class="text-xs rounded-full px-2 py-0.5 {{ $group === $groupName ? 'bg-navy text-white' : 'bg-slate-100 text-slate-500' }}">
                        {{ $count }}
                    </span>
                </button>
            @endforeach
        </nav>
    </aside>

    {{-- ── Main panel ──────────────────────────────────────────────────── --}}
    <div class="flex-1 min-w-0 rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200">

        {{-- Flash message --}}
        @if (session('status'))
            <div class="mx-6 mt-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- Search bar --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0Z"/>
            </svg>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search keys and values…"
                class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none"
            >
            @if ($search)
                <span class="text-xs text-slate-400">{{ count($rows) }} results</span>
            @endif
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-fixed">
                <thead>
                    <tr class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                        <th class="px-4 py-3 text-left font-semibold w-[16%]">Key</th>
                        <th class="px-4 py-3 text-left font-semibold w-[28%]">🇬🇧 English</th>
                        <th class="px-4 py-3 text-left font-semibold w-[28%]">🇪🇸 Spanish</th>
                        <th class="px-4 py-3 text-left font-semibold w-[28%]">🇭🇺 Hungarian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($rows as $i => $row)
                        <tr class="hover:bg-slate-50/50 transition-colors align-top">
                            {{-- Key (read-only, truncated with tooltip) --}}
                            <td class="px-4 py-3 max-w-0">
                                <code
                                    class="block text-[11px] text-dobero-blue font-mono truncate leading-relaxed cursor-default"
                                    title="{{ $row['key'] }}"
                                >{{ $row['key'] }}</code>
                            </td>

                            {{-- EN --}}
                            <td class="px-4 py-3">
                                @php $rows_en = mb_strlen($row['en']) > 60 ? 3 : 1; @endphp
                                <textarea
                                    wire:model="rows.{{ $i }}.en"
                                    rows="{{ $rows_en }}"
                                    class="w-full text-xs rounded-lg border border-slate-200 px-2.5 py-1.5 resize-y focus:outline-none focus:ring-1 focus:ring-dobero-blue/40 bg-white"
                                ></textarea>
                            </td>

                            {{-- ES --}}
                            <td class="px-4 py-3">
                                @php $rows_es = mb_strlen($row['es']) > 60 || mb_strlen($row['en']) > 60 ? 3 : 1; @endphp
                                <textarea
                                    wire:model="rows.{{ $i }}.es"
                                    rows="{{ $rows_es }}"
                                    class="w-full text-xs rounded-lg border border-slate-200 px-2.5 py-1.5 resize-y focus:outline-none focus:ring-1 focus:ring-dobero-blue/40 bg-white"
                                ></textarea>
                            </td>

                            {{-- HU --}}
                            <td class="px-4 py-3">
                                @php $rows_hu = mb_strlen($row['hu']) > 60 || mb_strlen($row['en']) > 60 ? 3 : 1; @endphp
                                <textarea
                                    wire:model="rows.{{ $i }}.hu"
                                    rows="{{ $rows_hu }}"
                                    class="w-full text-xs rounded-lg border border-slate-200 px-2.5 py-1.5 resize-y focus:outline-none focus:ring-1 focus:ring-dobero-blue/40 bg-white"
                                ></textarea>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">
                                No translations found{{ $search ? ' matching "' . $search . '"' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Save bar --}}
        <div class="sticky bottom-0 flex items-center justify-between gap-4 rounded-b-[2rem] border-t border-slate-100 bg-white/95 backdrop-blur px-6 py-4">
            <p class="text-xs text-slate-400">
                Changes are written directly to <code class="font-mono text-dobero-blue">lang/</code> files and take effect immediately.
            </p>
            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="btn-primary shrink-0"
            >
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>

    </div>
</div>
