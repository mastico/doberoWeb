<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PropertyLandingController;
use App\Http\Middleware\SetLocale;
use App\Livewire\Admin\BlogPostForm;
use App\Livewire\Admin\BlogPostsIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\NavBuilder;
use App\Livewire\Admin\NavItemForm;
use App\Livewire\Admin\PageForm;
use App\Livewire\Admin\PageSectionsEditor;
use App\Livewire\Admin\PagesIndex;
use App\Livewire\Admin\PropertiesIndex;
use App\Livewire\Admin\PropertyForm;
use App\Livewire\Admin\ServiceForm;
use App\Livewire\Admin\ServicesIndex;
use App\Livewire\Admin\SiteSettingsEditor;
use App\Livewire\Admin\TranslationsEditor;
use App\Livewire\Admin\FaqItemForm;
use App\Livewire\Admin\FaqItemsIndex;
use App\Livewire\Admin\UserForm;
use App\Livewire\Admin\UsersIndex;
use App\Livewire\Admin\TeamMemberForm;
use App\Livewire\Admin\TeamMembersIndex;
use App\Livewire\Admin\TestimonialForm;
use App\Livewire\Admin\TestimonialsIndex;
use App\Livewire\AboutPage;
use App\Livewire\Homepage;
use App\Livewire\PropertiesListing;
use App\Livewire\PropertyDetail;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

$corePage = function (string $key, string $view = 'pages.dynamic') {
    return function () use ($key, $view) {
        abort_unless(Schema::hasTable('pages'), 404);

        $page = Page::query()
            ->where('key', $key)
            ->where('is_published', true)
            ->first();

        abort_unless($page, 404);

        return view($view, compact('page'));
    };
};

$localizedRoutes = function (array $translations = []) use ($corePage): void {
    $t = fn (string $key): string => $translations[$key] ?? $key;

    Route::get('/', Homepage::class)->name('home');
    Route::get($t('about-us'), AboutPage::class)->name('about');
    Route::get($t('properties'), PropertiesListing::class)->name('properties.index');
    Route::get($t('properties').'/{id}', PropertyDetail::class)->name('properties.show');
    Route::get($t('properties').'/{type}-for-sale-in-{location}', [PropertyLandingController::class, 'show'])
        ->name('property.landing.sale')
        ->defaults('status', 'for_sale');
    Route::get($t('properties').'/{type}-for-rent-in-{location}', fn ($type, $location) => app(PropertyLandingController::class)->show($type, $location, 'for_rent'))
        ->name('property.landing.rent');
    Route::get($t('contact'), $corePage('contact', 'pages.contact'))->name('contact');
    Route::post($t('contact'), [ContactController::class, 'store'])->name('contact.store');
    Route::get($t('relocation'), $corePage('relocation', 'pages.relocation'))->name('relocation');
    Route::get($t('construction'), $corePage('construction', 'pages.construction'))->name('construction');
    Route::get($t('specials'), $corePage('specials', 'pages.specials'))->name('specials');
    Route::get('{slug}', [PageController::class, 'show'])
        ->name('pages.show')
        ->where('slug', '^(?!admin$|dashboard$|login$|logout$|register$|forgot-password$|reset-password$|two-factor-challenge$|up$|es$|hu$)[A-Za-z0-9\-]+$');
};

Route::middleware(SetLocale::class)->group(fn () => $localizedRoutes());

foreach (array_keys(config('locales.available', [])) as $code) {
    if ($code === config('locales.default')) {
        continue;
    }

    $translations = file_exists(lang_path("{$code}/routes.php")) ? require lang_path("{$code}/routes.php") : [];

    Route::prefix($code)
        ->name("{$code}.")
        ->middleware(SetLocale::class)
        ->group(fn () => $localizedRoutes($translations));
}

Route::redirect('/dashboard', '/admin');

Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/properties', PropertiesIndex::class)->name('properties.index');
    Route::get('/properties/create', PropertyForm::class)->name('properties.create');
    Route::get('/properties/{property}/edit', PropertyForm::class)->name('properties.edit');
    Route::get('/team', TeamMembersIndex::class)->name('team.index');
    Route::get('/team/create', TeamMemberForm::class)->name('team.create');
    Route::get('/team/{member}/edit', TeamMemberForm::class)->name('team.edit');
    Route::get('/testimonials', TestimonialsIndex::class)->name('testimonials.index');
    Route::get('/testimonials/create', TestimonialForm::class)->name('testimonials.create');
    Route::get('/testimonials/{testimonial}/edit', TestimonialForm::class)->name('testimonials.edit');
    Route::get('/services', ServicesIndex::class)->name('services.index');
    Route::get('/services/create', ServiceForm::class)->name('services.create');
    Route::get('/services/{service}/edit', ServiceForm::class)->name('services.edit');
    Route::get('/blog', BlogPostsIndex::class)->name('blog.index');
    Route::get('/blog/create', BlogPostForm::class)->name('blog.create');
    Route::get('/blog/{post}/edit', BlogPostForm::class)->name('blog.edit');
    Route::get('/page-sections', PageSectionsEditor::class)->name('page-sections');
    Route::get('/settings', SiteSettingsEditor::class)->name('settings');
    Route::get('/navigation', NavBuilder::class)->name('navigation.index');
    Route::get('/navigation/create', NavItemForm::class)->name('navigation.create');
    Route::get('/navigation/{item}/edit', NavItemForm::class)->name('navigation.edit');
    Route::get('/pages', PagesIndex::class)->name('pages.index');
    Route::get('/pages/create', PageForm::class)->name('pages.create');
    Route::get('/pages/{page}/edit', PageForm::class)->name('pages.edit');
    Route::get('/translations', TranslationsEditor::class)->name('translations');
    Route::get('/users', UsersIndex::class)->name('users.index');
    Route::get('/users/create', UserForm::class)->name('users.create');
    Route::get('/users/{user}/edit', UserForm::class)->name('users.edit');
    Route::get('/faqs', FaqItemsIndex::class)->name('faqs.index');
    Route::get('/faqs/create', FaqItemForm::class)->name('faqs.create');
    Route::get('/faqs/{faq}/edit', FaqItemForm::class)->name('faqs.edit');
});
