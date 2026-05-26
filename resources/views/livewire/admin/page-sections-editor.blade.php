<div class="grid gap-6 xl:grid-cols-[320px,1fr]">
    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <label class="form-label">Page</label>
        <select wire:model.live="page" class="form-input">
            @foreach ($pages as $pageOption)
                <option value="{{ $pageOption }}">{{ ucfirst($pageOption) }}</option>
            @endforeach
        </select>
        <div class="mt-6 space-y-3">
            @foreach ($sections as $section)
                <button type="button" wire:click="selectSection({{ $section->id }})" class="block w-full rounded-2xl px-4 py-3 text-left {{ $selectedSectionId === $section->id ? 'bg-navy text-white' : 'bg-slate-50 text-slate-700' }}">
                    <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $section->section_key)) }}</p>
                    <p class="text-xs opacity-70">{{ $section->getTranslation('title', 'en', false) }}</p>
                </button>
            @endforeach
        </div>
    </div>
    <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
        @if (session('status'))
            <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($selectedSectionId)
            <div class="mb-6 flex gap-1 border-b border-slate-200">
                @foreach (available_locales() as $code => $info)
                    <button type="button" wire:click="$set('activeLocale', '{{ $code }}')" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $info['short'] }}</button>
                @endforeach
            </div>
            <form wire:submit="save" class="space-y-6">
                <div><label class="form-label">Title</label><input wire:model="form.title.{{ $activeLocale }}" class="form-input"></div>
                <div><label class="form-label">Subtitle</label><input wire:model="form.subtitle.{{ $activeLocale }}" class="form-input"></div>
                <div><label class="form-label">Content</label><textarea wire:model="form.content.{{ $activeLocale }}" rows="6" class="form-input"></textarea></div>
                <div><label class="form-label">Extra JSON</label><textarea wire:model="form.extra" rows="12" class="form-input font-mono text-sm"></textarea>@error('form.extra')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div><label class="form-label">Sort Order</label><input type="number" wire:model="form.sort_order" class="form-input"></div>
                    <div class="flex items-center gap-3 pt-8"><input type="checkbox" wire:model="form.is_active" class="rounded border-slate-300 text-dobero-blue"><label class="text-sm text-slate-600">Active</label></div>
                </div>
                <button class="btn-primary">Save Section</button>
            </form>
        @else
            <p class="text-sm text-slate-500">No sections found for this page yet.</p>
        @endif
    </div>
</div>
