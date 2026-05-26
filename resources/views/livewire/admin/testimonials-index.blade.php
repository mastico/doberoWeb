<div class="space-y-6">
    @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
    <div class="flex justify-end"><a href="{{ route('admin.testimonials.create') }}" class="btn-primary">Add Testimonial</a></div>
    <div class="grid gap-6 lg:grid-cols-3">
        @foreach ($testimonials as $testimonial)
            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm leading-7 text-slate-600">{{ $testimonial->content }}</p>
                <p class="mt-4 font-semibold text-navy">{{ $testimonial->author_name }}</p>
                <div class="mt-6 flex justify-between text-sm"><a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-dobero-blue">Edit</a><button wire:click="delete({{ $testimonial->id }})" wire:confirm="Delete this testimonial?" class="text-rose-600">Delete</button></div>
            </div>
        @endforeach
    </div>
</div>
