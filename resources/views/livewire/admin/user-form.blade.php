<div class="max-w-xl space-y-6">
    @if (session('status'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 space-y-6">

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
            <input
                type="text"
                wire:model="name"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-dobero-blue/40"
                placeholder="Full name"
                autofocus
            >
            @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input
                type="email"
                wire:model="email"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-dobero-blue/40"
                placeholder="email@example.com"
            >
            @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            @if ($user?->exists && $user->email !== $email)
                <p class="mt-1 text-xs text-amber-500">Changing the email will require the user to re-verify their address.</p>
            @endif
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Password
                @if ($user?->exists)
                    <span class="text-slate-400 font-normal">(leave blank to keep current)</span>
                @endif
            </label>
            <input
                type="password"
                wire:model="password"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-dobero-blue/40"
                placeholder="{{ $user?->exists ? '••••••••' : 'Minimum 8 characters' }}"
                autocomplete="new-password"
            >
            @error('password') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        {{-- Password confirmation --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
            <input
                type="password"
                wire:model="password_confirmation"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-dobero-blue/40"
                placeholder="••••••••"
                autocomplete="new-password"
            >
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-500 hover:text-slate-700">← Cancel</a>
            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="btn-primary"
            >
                <span wire:loading.remove wire:target="save">{{ $user?->exists ? 'Update User' : 'Create User' }}</span>
                <span wire:loading wire:target="save">Saving…</span>
            </button>
        </div>
    </div>
</div>
