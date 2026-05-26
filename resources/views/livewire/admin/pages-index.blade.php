<div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search pages..." class="form-input md:max-w-sm">
        <a href="{{ route('admin.pages.create') }}" class="btn-primary">Create page</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="px-4 py-3 font-semibold">Title (EN)</th>
                    <th class="px-4 py-3 font-semibold">Key</th>
                    <th class="px-4 py-3 font-semibold">Published</th>
                    <th class="px-4 py-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($pages as $page)
                    <tr>
                        <td class="px-4 py-4 font-semibold text-navy">{{ $page->getTranslation('title', 'en', false) }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $page->key }}</td>
                        <td class="px-4 py-4"><button type="button" wire:click="togglePublished({{ $page->id }})" class="rounded-full px-3 py-1 text-xs font-semibold {{ $page->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $page->is_published ? 'Published' : 'Draft' }}</button></td>
                        <td class="px-4 py-4"><div class="flex flex-wrap gap-2"><a href="{{ route('admin.pages.edit', $page) }}" class="rounded-full border border-slate-300 px-3 py-1">Edit</a>@if ($page->deletable)<button type="button" wire:click="delete({{ $page->id }})" class="rounded-full border border-rose-200 px-3 py-1 text-rose-600">Delete</button>@else<span class="rounded-full border border-slate-200 px-3 py-1 text-slate-400">Core page</span>@endif</div></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
