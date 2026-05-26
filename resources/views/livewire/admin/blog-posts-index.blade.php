<div class="space-y-6">
    @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
    <div class="flex justify-end"><a href="{{ route('admin.blog.create') }}" class="btn-primary">Add Blog Post</a></div>
    <div class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-slate-500"><tr><th class="px-6 py-4">Title</th><th class="px-6 py-4">Category</th><th class="px-6 py-4">Published</th><th class="px-6 py-4 text-right">Actions</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4"><p class="font-semibold text-navy">{{ $post->title }}</p><p class="text-slate-500">{{ $post->author }}</p></td>
                        <td class="px-6 py-4">{{ $post->category }}</td>
                        <td class="px-6 py-4">{{ $post->is_published ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-4 text-right"><a href="{{ route('admin.blog.edit', $post) }}" class="text-dobero-blue">Edit</a><button wire:click="delete({{ $post->id }})" wire:confirm="Delete this post?" class="ml-4 text-rose-600">Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
