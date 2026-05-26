<x-layouts.app :title="$page?->meta_title ?: ($page?->title ?: __('Contact'))" :description="$page?->meta_description ?: ''">
    <section class="bg-navy px-6 pb-20 pt-36 text-white lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="section-kicker text-white/70">{{ __('CONTACT') }}</p>
            <h1 class="mt-3 text-5xl font-semibold">{{ $page?->title ?? __("Let's Talk About Your Next Move") }}</h1>
            <div class="mt-5 max-w-3xl text-lg text-white/75">
                {!! $page?->body ?? '<p>' . __('Share your goals and DOBERO HOME CREATOR will help you shortlist properties, assess opportunities, and plan the next steps.') . '</p>' !!}
            </div>
        </div>
    </section>
    <section class="section-shell bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-[0.9fr,1.1fr] lg:px-8">
            <div class="rounded-[2rem] bg-slate-50 p-8">
                <h2 class="text-2xl font-semibold text-navy">{{ __('Contact Information') }}</h2>
                <div class="mt-6 space-y-4 text-slate-600">
                    <p>{{ \App\Models\SiteSetting::get('address', 'Passeig de Gràcia 125, Barcelona, Spain') }}</p>
                    <p>{{ \App\Models\SiteSetting::get('phone', '+1 (800) 123 4567') }}</p>
                    <p>{{ \App\Models\SiteSetting::get('email', 'info@dobero.com') }}</p>
                </div>
            </div>
            <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">@csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <div><label class="form-label">{{ __('First Name') }}</label><input name="first_name" class="form-input" required></div>
                        <div><label class="form-label">{{ __('Last Name') }}</label><input name="last_name" class="form-input" required></div>
                        <div><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-input" required></div>
                        <div><label class="form-label">{{ __('Phone') }}</label><input name="phone" class="form-input"></div>
                    </div>
                    <div>
                        <label class="form-label">{{ __('Inquiry Type') }}</label>
                        <select name="inquiry_type" class="form-input">
                            <option value="">{{ __('General Inquiry') }}</option>
                            <option value="buy">{{ __('Buying') }}</option>
                            <option value="rent">{{ __('Renting') }}</option>
                            <option value="construction">{{ __('Construction') }}</option>
                            <option value="relocation">{{ __('Relocation') }}</option>
                        </select>
                    </div>
                    <div><label class="form-label">{{ __('Message') }}</label><textarea name="message" rows="6" class="form-input"></textarea></div>
                    <button class="btn-primary">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
