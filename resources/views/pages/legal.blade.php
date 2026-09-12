<x-layouts.app :title="$page->meta_title ?: $page->title" :description="$page->meta_description ?: ''">
    <article class="section-shell bg-white pt-36">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <div class="prose max-w-none">
                <h1>{{ $page->title }}</h1>
                {!! $page->body !!}
            </div>

            @if ($page->key === 'legal-notice')
                <div class="not-prose mt-10 rounded-2xl bg-slate-50 p-6">
                    <h2 class="text-xl font-semibold text-navy">{{ __('Legal Notice') }}</h2>
                    <dl class="mt-4 grid gap-4 text-sm text-slate-700 sm:grid-cols-2">
                        <div>
                            <dt class="font-medium text-navy">{{ __('Owner') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('legal_owner') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-navy">{{ __('NIF') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('legal_nif') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-navy">{{ __('Trade name') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('legal_trade_name') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-navy">{{ __('Business activity') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('legal_activity') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-navy">{{ __('Professional address') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('legal_address') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-navy">{{ __('Phone') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('phone') }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-navy">{{ __('Email') }}</dt>
                            <dd class="mt-1">{{ \App\Models\SiteSetting::get('email') }}</dd>
                        </div>
                    </dl>
                </div>
            @endif
        </div>
    </article>
</x-layouts.app>
