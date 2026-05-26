<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <select wire:model.live="filterPage" class="form-input w-auto text-sm">
                <option value="">All pages</option>
                @foreach ($pages as $pg)
                    <option value="{{ $pg }}">{{ ucfirst($pg) }}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('admin.faqs.create') }}" wire:navigate class="btn-primary">+ Add FAQ</a>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                <th class="pb-3 pr-4">Page</th>
                <th class="pb-3 pr-4">Question (EN)</th>
                <th class="pb-3 pr-4">Order</th>
                <th class="pb-3 pr-4">Active</th>
                <th class="pb-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($faqs as $faq)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 pr-4 font-medium text-slate-600">{{ ucfirst($faq->page) }}</td>
                    <td class="py-3 pr-4 text-slate-800">{{ Str::limit($faq->getTranslation('question', 'en'), 80) }}</td>
                    <td class="py-3 pr-4 text-slate-500">{{ $faq->sort_order }}</td>
                    <td class="py-3 pr-4">
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $faq->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $faq->is_active ? 'Active' : 'Draft' }}
                        </span>
                    </td>
                    <td class="py-3 text-right">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" wire:navigate class="mr-3 text-dobero-blue hover:underline">Edit</a>
                        <button wire:click="delete({{ $faq->id }})" wire:confirm="Delete this FAQ?" class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-slate-400">No FAQ items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
