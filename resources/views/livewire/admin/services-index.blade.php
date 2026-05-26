<div class="space-y-6">
    @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
    <div class="flex justify-end"><a href="{{ route('admin.services.create') }}" class="btn-primary">Add Service</a></div>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($services as $service)
            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h3 class="text-xl font-semibold text-navy">{{ $service->title }}</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $service->description }}</p>
                <div class="mt-6 flex justify-between text-sm"><a href="{{ route('admin.services.edit', $service) }}" class="text-dobero-blue">Edit</a><button wire:click="delete({{ $service->id }})" wire:confirm="Delete this service?" class="text-rose-600">Delete</button></div>
            </div>
        @endforeach
    </div>
</div>
