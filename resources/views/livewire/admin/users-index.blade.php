<div class="space-y-6">
    @if (session('status'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="flex justify-end">
        <a href="{{ route('admin.users.create') }}" class="btn-primary">Add User</a>
    </div>

    <div class="rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <th class="px-6 py-3 text-left font-semibold">Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-left font-semibold">Verified</th>
                    <th class="px-6 py-3 text-left font-semibold">2FA</th>
                    <th class="px-6 py-3 text-left font-semibold">Joined</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-navy">
                            <div class="flex items-center gap-3">
                                @if ($user->profile_photo_path)
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-navy/10 text-xs font-bold text-navy">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="text-[10px] bg-dobero-blue/10 text-dobero-blue px-2 py-0.5 rounded-full font-semibold">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if ($user->email_verified_at)
                                <span class="text-emerald-600 text-xs font-semibold">✓ Verified</span>
                            @else
                                <span class="text-amber-500 text-xs font-semibold">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->two_factor_confirmed_at)
                                <span class="text-emerald-600 text-xs font-semibold">✓ Enabled</span>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right space-x-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-dobero-blue text-sm hover:underline">Edit</a>
                            @if ($user->id !== auth()->id())
                                <button
                                    wire:click="delete({{ $user->id }})"
                                    wire:confirm="Delete user {{ $user->name }}? This cannot be undone."
                                    class="text-rose-600 text-sm hover:underline"
                                >Delete</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-400">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
