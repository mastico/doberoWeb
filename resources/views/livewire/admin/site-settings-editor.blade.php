<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @foreach (available_locales() as $code => $info)
            <button type="button" wire:click="$set('activeLocale', '{{ $code }}')" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $info['short'] }}</button>
        @endforeach
    </div>

    <form wire:submit="save" class="grid gap-6 lg:grid-cols-2">
        @foreach ($records as $record)
            <div class="{{ $record->type === 'textarea' ? 'lg:col-span-2' : '' }}">
                <label class="form-label">{{ ucwords(str_replace('_', ' ', $record->key)) }}</label>
                @if ($record->is_translatable)
                    @if ($record->type === 'textarea')
                        <textarea wire:model="settings.{{ $record->key }}.{{ $activeLocale }}" rows="4" class="form-input"></textarea>
                    @else
                        <input wire:model="settings.{{ $record->key }}.{{ $activeLocale }}" class="form-input">
                    @endif
                @else
                    @if ($record->type === 'textarea')
                        <textarea wire:model="settings.{{ $record->key }}" rows="4" class="form-input"></textarea>
                    @else
                        <input wire:model="settings.{{ $record->key }}" class="form-input">
                    @endif
                @endif
            </div>
        @endforeach
        <div class="lg:col-span-2"><label class="form-label">Logo Upload</label><input type="file" wire:model="logoUpload" class="form-input"></div>
        <div class="lg:col-span-2"><button class="btn-primary">Save Settings</button></div>
    </form>
</div>
