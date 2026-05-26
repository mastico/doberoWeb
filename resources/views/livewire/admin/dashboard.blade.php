<div class="space-y-8">
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
        @foreach ($stats as $label => $value)
            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-400">{{ ucfirst($label) }}</p>
                <p class="mt-4 text-4xl font-semibold text-navy">{{ $value }}</p>
            </div>
        @endforeach
    </div>
    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-xl font-semibold text-navy">Recent Inquiries</h2>
            <div class="mt-6 space-y-4">
                @forelse ($recentInquiries as $inquiry)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="font-semibold text-navy">{{ $inquiry->first_name }} {{ $inquiry->last_name }}</p>
                        <p class="text-sm text-slate-500">{{ $inquiry->email }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($inquiry->message, 120) }}</p>
                    </div>
                @empty <p class="text-slate-500">No inquiries yet.</p> @endforelse
            </div>
        </div>
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-xl font-semibold text-navy">Recent Properties</h2>
            <div class="mt-6 space-y-4">
                @foreach ($recentProperties as $property)
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4">
                        <div>
                            <p class="font-semibold text-navy">{{ $property->title }}</p>
                            <p class="text-sm text-slate-500">{{ $property->city }}</p>
                        </div>
                        <p class="text-sm font-semibold text-dobero-blue">€{{ number_format($property->price, 0) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
