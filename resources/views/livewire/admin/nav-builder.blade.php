<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-navy">Primary Navigation</h2>
            <p class="text-sm text-slate-500">Manage menu items and their order.</p>
        </div>
        <a href="{{ route('admin.navigation.create') }}" class="btn-primary">Add top-level item</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="px-4 py-3 font-semibold">Label (EN)</th>
                    <th class="px-4 py-3 font-semibold">URL (EN)</th>
                    <th class="px-4 py-3 font-semibold">Location</th>
                    <th class="px-4 py-3 font-semibold">Active</th>
                    <th class="px-4 py-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($items as $item)
                    <tr>
                        <td class="px-4 py-4 font-semibold text-navy">{{ $item->getTranslation('label', 'en', false) }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $item->getTranslation('url', 'en', false) }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $item->location }}</td>
                        <td class="px-4 py-4"><button type="button" wire:click="toggleActive({{ $item->id }})" class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</button></td>
                        <td class="px-4 py-4"><div class="flex flex-wrap gap-2"><button type="button" wire:click="moveUp({{ $item->id }})" class="rounded-full border border-slate-300 px-3 py-1">↑</button><button type="button" wire:click="moveDown({{ $item->id }})" class="rounded-full border border-slate-300 px-3 py-1">↓</button><a href="{{ route('admin.navigation.edit', $item) }}" class="rounded-full border border-slate-300 px-3 py-1">Edit</a><button type="button" wire:click="delete({{ $item->id }})" class="rounded-full border border-rose-200 px-3 py-1 text-rose-600">Delete</button></div></td>
                    </tr>
                    @foreach ($item->children as $child)
                        <tr class="bg-slate-50/70">
                            <td class="px-4 py-4 pl-10 font-medium text-slate-700">↳ {{ $child->getTranslation('label', 'en', false) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $child->getTranslation('url', 'en', false) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $child->location }}</td>
                            <td class="px-4 py-4"><button type="button" wire:click="toggleActive({{ $child->id }})" class="rounded-full px-3 py-1 text-xs font-semibold {{ $child->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $child->is_active ? 'Active' : 'Hidden' }}</button></td>
                            <td class="px-4 py-4"><div class="flex flex-wrap gap-2"><button type="button" wire:click="moveUp({{ $child->id }})" class="rounded-full border border-slate-300 px-3 py-1">↑</button><button type="button" wire:click="moveDown({{ $child->id }})" class="rounded-full border border-slate-300 px-3 py-1">↓</button><a href="{{ route('admin.navigation.edit', $child) }}" class="rounded-full border border-slate-300 px-3 py-1">Edit</a><button type="button" wire:click="delete({{ $child->id }})" class="rounded-full border border-rose-200 px-3 py-1 text-rose-600">Delete</button></div></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
