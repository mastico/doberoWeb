<div class="space-y-6">
    @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search properties" class="form-input max-w-md">
        <a href="{{ route('admin.properties.create') }}" class="btn-primary">Add Property</a>
    </div>
    <div class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-slate-500"><tr><th class="px-6 py-4">Property</th><th class="px-6 py-4">Type</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Price</th><th class="px-6 py-4 text-right">Actions</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($properties as $property)
                    <tr>
                        <td class="px-6 py-4"><p class="font-semibold text-navy">{{ $property->title }}</p><p class="text-slate-500">{{ $property->city }}</p></td>
                        <td class="px-6 py-4">{{ ucfirst($property->property_type) }}</td>
                        <td class="px-6 py-4">{{ ucwords(str_replace('_', ' ', $property->status)) }}</td>
                        <td class="px-6 py-4">€{{ number_format($property->price, 0) }}</td>
                        <td class="px-6 py-4 text-right"><a href="{{ route('admin.properties.edit', $property) }}" class="text-dobero-blue">Edit</a> <button wire:click="delete({{ $property->id }})" wire:confirm="Delete this property?" class="ml-4 text-rose-600">Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $properties->links() }}
</div>
