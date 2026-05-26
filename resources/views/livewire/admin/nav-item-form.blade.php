<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @foreach (available_locales() as $code => $info)
            <button type="button" wire:click="$set('activeLocale', '{{ $code }}')" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $info['short'] }}</button>
        @endforeach
    </div>

    <form wire:submit="save" class="grid gap-6 lg:grid-cols-2">
        <div><label class="form-label">Label</label><input wire:model="form.label.{{ $activeLocale }}" class="form-input"></div>
        <div><label class="form-label">URL</label><input wire:model="form.url.{{ $activeLocale }}" class="form-input"></div>
        <div><label class="form-label">Parent Item</label><select wire:model="form.parent_id" class="form-input"><option value="">None</option>@foreach ($rootItems as $root)<option value="{{ $root->id }}">{{ $root->getTranslation('label', 'en', false) }}</option>@endforeach</select></div>
        <div><label class="form-label">Location</label><select wire:model="form.location" class="form-input"><option value="primary">Primary</option><option value="footer">Footer</option></select></div>
        <div><label class="form-label">Sort Order</label><input type="number" wire:model="form.sort_order" class="form-input"></div>
        <div class="space-y-3 pt-8"><label class="flex items-center gap-3 text-sm text-slate-600"><input type="checkbox" wire:model="form.is_active" class="rounded border-slate-300 text-dobero-blue">Active</label><label class="flex items-center gap-3 text-sm text-slate-600"><input type="checkbox" wire:model="form.opens_in_new_tab" class="rounded border-slate-300 text-dobero-blue">Open in new tab</label></div>
        <div class="lg:col-span-2 flex gap-4"><button class="btn-primary">Save Navigation Item</button><a href="{{ route('admin.navigation.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-600">Cancel</a></div>
    </form>
</div>
