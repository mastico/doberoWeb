<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    <div class="mb-6 flex gap-1 border-b border-slate-200">
        @foreach (available_locales() as $code => $info)
            <button type="button" wire:click="$set('activeLocale', '{{ $code }}')" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-colors {{ $activeLocale === $code ? 'bg-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $info['short'] }}</button>
        @endforeach
    </div>
    <form wire:submit="save" class="grid gap-6 lg:grid-cols-2">
        <div class="lg:col-span-2"><label class="form-label">Content</label><textarea wire:model="form.content.{{ $activeLocale }}" rows="5" class="form-input"></textarea></div>
        <div><label class="form-label">Author Name</label><input wire:model="form.author_name" class="form-input"></div>
        <div><label class="form-label">Author Role</label><input wire:model="form.author_role.{{ $activeLocale }}" class="form-input"></div>
        <div><label class="form-label">Author Company</label><input wire:model="form.author_company" class="form-input"></div>
        <div><label class="form-label">Sort Order</label><input type="number" wire:model="form.sort_order" class="form-input"></div>
        <div class="flex items-center gap-3"><input type="checkbox" wire:model="form.is_active" class="rounded border-slate-300 text-dobero-blue"><label class="text-sm text-slate-600">Active</label></div>
        <div class="lg:col-span-2"><label class="form-label">Author Photo</label><input type="file" wire:model="photoUpload" class="form-input"></div>
        <div class="lg:col-span-2 flex gap-4"><button class="btn-primary">Save Testimonial</button><a href="{{ route('admin.testimonials.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-600">Cancel</a></div>
    </form>
</div>
