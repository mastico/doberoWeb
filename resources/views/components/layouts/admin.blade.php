@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' | ' : '' }}Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
<div class="min-h-screen lg:flex">
    <aside class="w-full bg-navy text-white lg:w-72">
        <div class="border-b border-white/10 px-6 py-6">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-xl font-bold">D</div>
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/60">Admin</p>
                    <p class="text-lg font-semibold">DOBERO</p>
                </div>
            </a>
        </div>
        <nav class="space-y-1 px-4 py-6 text-sm">
            @foreach ([
                'Dashboard' => route('admin.dashboard'),
                'Properties' => route('admin.properties.index'),
                'Team Members' => route('admin.team.index'),
                'Testimonials' => route('admin.testimonials.index'),
                'Services' => route('admin.services.index'),
                'Blog Posts' => route('admin.blog.index'),
                'Navigation' => route('admin.navigation.index'),
                'Pages' => route('admin.pages.index'),
                'Page Sections' => route('admin.page-sections'),
                'Site Settings' => route('admin.settings'),
                'Translations' => route('admin.translations'),
            ] as $label => $url)
                <a href="{{ $url }}" class="block rounded-xl px-4 py-3 transition hover:bg-white/10">{{ $label }}</a>
            @endforeach
            <a href="{{ route('home') }}" class="mt-4 block rounded-xl border border-white/15 px-4 py-3 transition hover:bg-white/10">View Site</a>
        </nav>
    </aside>
    <div class="flex-1">
        <header class="border-b border-slate-200 bg-white px-6 py-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-dobero-blue">Administration</p>
                    <h1 class="text-2xl font-semibold text-navy">{{ $title }}</h1>
                </div>
                @auth
                    <div class="text-right text-sm text-slate-500">
                        <p>{{ auth()->user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-dobero-blue">Logout</button></form>
                    </div>
                @endauth
            </div>
        </header>
        <main class="p-6">{{ $slot }}</main>
    </div>
</div>
@livewireScripts
</body>
</html>
