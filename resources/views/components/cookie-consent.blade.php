@php
    $storageKey = 'dobero_cookie_consent';
    $consentVersion = 1;
    $defaultConsent = [
        'necessary' => true,
        'analytics' => false,
        'marketing' => false,
        'version' => $consentVersion,
    ];
@endphp

<div
    x-data="window.doberoCookieConsent.create({
        storageKey: @js($storageKey),
        version: {{ $consentVersion }},
        defaultConsent: @js($defaultConsent),
        openEvent: 'dobero:open-cookie-settings',
        changeEvent: 'dobero:consent-changed',
    })"
    x-init="init()"
    data-cookie-consent-key="{{ $storageKey }}"
    data-cookie-consent-version="{{ $consentVersion }}"
>
    <div
        x-cloak
        x-show="bannerVisible"
        x-transition.opacity
        class="fixed inset-x-0 bottom-0 z-[90] px-4 pb-4 sm:px-6"
        aria-live="polite"
    >
        <div class="mx-auto w-full max-w-5xl rounded-3xl border border-navy/10 bg-white p-6 shadow-2xl ring-1 ring-black/5">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-dobero-blue">
                        {{ __('Cookie Settings') }}
                    </p>
                    <h2 class="text-2xl font-semibold text-navy">
                        {{ __('Choose which cookies you want to allow.') }}
                    </h2>
                    <p class="text-sm leading-7 text-slate-600">
                        {{ __('We only use necessary cookies by default. You can accept or reject optional analytics and marketing cookies, or configure them individually at any time.') }}
                    </p>
                </div>

                <div class="grid w-full gap-3 sm:grid-cols-3 lg:max-w-xl">
                    <button
                        type="button"
                        @click="save(false, false)"
                        class="inline-flex w-full items-center justify-center rounded-full border border-navy/20 bg-white px-5 py-3 text-sm font-semibold text-navy transition hover:border-navy hover:bg-slate-50"
                    >
                        {{ __('Reject') }}
                    </button>
                    <button
                        type="button"
                        @click="save(true, true)"
                        class="inline-flex w-full items-center justify-center rounded-full border border-navy/20 bg-white px-5 py-3 text-sm font-semibold text-navy transition hover:border-navy hover:bg-slate-50"
                    >
                        {{ __('Accept') }}
                    </button>
                    <button
                        type="button"
                        @click="openSettings()"
                        class="inline-flex w-full items-center justify-center rounded-full border border-navy/20 bg-white px-5 py-3 text-sm font-semibold text-navy transition hover:border-navy hover:bg-slate-50"
                    >
                        {{ __('Configure') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="settingsVisible"
        x-transition.opacity
        class="fixed inset-0 z-[100] flex items-end justify-center bg-slate-950/60 p-4 sm:items-center sm:p-6"
        aria-modal="true"
        role="dialog"
        aria-labelledby="cookie-settings-title"
        @click.self="closeSettings()"
        @keydown.escape.window="closeSettings()"
    >
        <div class="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-2xl sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-dobero-blue">
                        {{ __('Cookie Settings') }}
                    </p>
                    <h2 id="cookie-settings-title" class="text-2xl font-semibold text-navy">
                        {{ __('Manage your cookie preferences') }}
                    </h2>
                    <p class="text-sm leading-7 text-slate-600">
                        {{ __('Necessary cookies are always enabled. Optional categories stay off unless you turn them on and save your preferences.') }}
                    </p>
                </div>

                <button
                    type="button"
                    @click="closeSettings()"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-slate-300 hover:text-slate-700"
                    aria-label="{{ __('Close menu') }}"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="mt-8 space-y-4">
                <div class="rounded-2xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-navy">{{ __('Necessary') }}</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                {{ __('These cookies are required for core site functionality and are always active.') }}
                            </p>
                        </div>

                        <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-500">
                            <input type="checkbox" checked disabled class="h-5 w-5 rounded border-slate-300 text-navy focus:ring-navy">
                            <span>{{ __('Always active') }}</span>
                        </label>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-navy">{{ __('Analytics') }}</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                {{ __('Help us understand how visitors use the site so we can improve the experience.') }}
                            </p>
                        </div>

                        <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                            <input x-model="analytics" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-navy focus:ring-navy">
                            <span>{{ __('Analytics') }}</span>
                        </label>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-navy">{{ __('Marketing') }}</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                {{ __('Allow future marketing cookies only if you want personalized campaigns or advertising features.') }}
                            </p>
                        </div>

                        <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                            <input x-model="marketing" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-navy focus:ring-navy">
                            <span>{{ __('Marketing') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ locale_route('cookie-policy') }}" class="text-sm font-semibold text-dobero-blue transition hover:text-dobero-accent">
                    {{ __('Cookie Policy') }}
                </a>

                <button
                    type="button"
                    @click="savePreferences()"
                    class="inline-flex items-center justify-center rounded-full border border-navy bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-navy-dark"
                >
                    {{ __('Save preferences') }}
                </button>
            </div>
        </div>
    </div>
</div>
