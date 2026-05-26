<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <a href="{{ route('admin.faqs.index') }}" wire:navigate class="mb-6 inline-block text-sm text-slate-500 hover:text-slate-800">← Back to FAQ Items</a>

    {{-- Locale tabs --}}
    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @foreach (available_locales() as $code => $info)
            <button type="button" wire:click="$set('activeLocale', '{{ $code }}')"
                class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                {{ $info['short'] }}
            </button>
        @endforeach
    </div>

    <form wire:submit="save" class="grid gap-6 lg:grid-cols-2">
        {{-- Page --}}
        <div>
            <label class="form-label">Page</label>
            <select wire:model="form.page" class="form-input">
                @foreach ($pageOptions as $opt)
                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                @endforeach
            </select>
            @error('form.page') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        {{-- Sort order --}}
        <div>
            <label class="form-label">Sort Order</label>
            <input type="number" wire:model="form.sort_order" class="form-input" min="0">
        </div>

        {{-- Active --}}
        <div class="flex items-center gap-2 lg:col-span-2">
            <input id="is_active" type="checkbox" wire:model="form.is_active" class="h-4 w-4 rounded border-slate-300 text-dobero-blue">
            <label for="is_active" class="text-sm text-slate-700">Active (visible on site)</label>
        </div>

        {{-- Question --}}
        <div class="lg:col-span-2">
            <label class="form-label">Question <span class="ml-1 text-xs text-slate-400 uppercase">{{ $activeLocale }}</span></label>
            <input wire:model="form.question.{{ $activeLocale }}" class="form-input">
            @error("form.question.{$activeLocale}") <p class="form-error">{{ $message }}</p> @enderror
        </div>

        {{-- Answer --}}
        <div class="lg:col-span-2">
            <label class="form-label">Answer <span class="ml-1 text-xs text-slate-400 uppercase">{{ $activeLocale }}</span></label>
            <textarea wire:model="form.answer.{{ $activeLocale }}" rows="5" class="form-input"></textarea>
            @error("form.answer.{$activeLocale}") <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="lg:col-span-2">
            <button class="btn-primary">Save FAQ</button>
        </div>
    </form>
</div>
