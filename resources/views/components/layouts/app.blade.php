@props(['title' => null, 'description' => null, 'canonical' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' — ' : '' }}{{ \App\Models\SiteSetting::get('site_name', config('app.name')) }}</title>
    <meta name="description" content="{{ $description ?: \App\Models\SiteSetting::get('seo_default_description', \App\Models\SiteSetting::get('site_description', 'Curated Spanish real estate, relocation, and construction.')) }}">
    <link rel="canonical" href="{{ $canonical ?: url()->current() }}">
    @foreach (available_locales() as $code => $info)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ switch_locale_url($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ switch_locale_url(default_locale()) }}">
    <x-seo.organization />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white font-sans text-body antialiased">
    <div class="relative min-h-screen overflow-x-clip">
        <x-nav />
        <main>
            {{ $slot }}
        </main>
        <x-footer />
    </div>
    @livewireScripts
</body>
</html>
