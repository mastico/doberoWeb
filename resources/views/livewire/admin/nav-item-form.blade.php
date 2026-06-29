<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <form wire:submit="save" class="space-y-8">
        <div class="grid gap-6 lg:grid-cols-2">
            <div>
                <label class="form-label">Parent Item</label>
                <select wire:model="form.parent_id" class="form-input">
                    <option value="">None</option>
                    @foreach ($rootItems as $root)
                        <option value="{{ $root->id }}">{{ $root->getTranslation('label', 'en', false) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Location</label>
                <select wire:model="form.location" class="form-input">
                    <option value="primary">Primary</option>
                    <option value="footer">Footer</option>
                </select>
            </div>
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" wire:model="form.sort_order" class="form-input">
            </div>
            <div class="space-y-3 pt-8">
                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" wire:model="form.is_active" class="rounded border-slate-300 text-dobero-blue">
                    Active
                </label>
                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" wire:model="form.opens_in_new_tab" class="rounded border-slate-300 text-dobero-blue">
                    Open in new tab
                </label>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            @foreach (available_locales() as $code => $info)
                <section class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-navy">{{ $info['name'] }}</p>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $info['short'] }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Label</label>
                            <input wire:model="form.label.{{ $code }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">URL</label>
                            <input wire:model="form.url.{{ $code }}" class="form-input">
                        </div>
                    </div>
                </section>
            @endforeach
        </div>

        <div class="flex gap-4">
            <button class="btn-primary">Save Navigation Item</button>
            <a href="{{ route('admin.navigation.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-600">Cancel</a>
        </div>
    </form>
</div>
