<div class="space-y-6">
    @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
    <div class="flex justify-end"><a href="{{ route('admin.team.create') }}" class="btn-primary">Add Team Member</a></div>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($members as $member)
            @php $photo = image_url($member->photo, '/images/defaults/avatar-placeholder.jpg'); @endphp
            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <img src="{{ $photo ?: asset('images/defaults/avatar-placeholder.jpg') }}" class="h-40 w-full rounded-2xl object-cover">
                <h3 class="mt-5 text-xl font-semibold text-navy">{{ $member->name }}</h3>
                <p class="mt-2 text-sm uppercase tracking-[0.25em] text-dobero-blue">{{ $member->role }}</p>
                <div class="mt-6 flex justify-between text-sm"><a href="{{ route('admin.team.edit', $member) }}" class="text-dobero-blue">Edit</a><button wire:click="delete({{ $member->id }})" wire:confirm="Delete this member?" class="text-rose-600">Delete</button></div>
            </div>
        @endforeach
    </div>
</div>
