<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Admin\PageForm;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    // ── Static core pages ────────────────────────────────────────────────────

    public function test_seeded_about_page_resolves_on_english_url(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/about-us')
            ->assertOk()
            ->assertSee('About');
    }

    public function test_seeded_relocation_page_resolves_on_spanish_url(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/es/reubicacion')
            ->assertOk();
    }

    public function test_unpublished_page_returns_404(): void
    {
        Page::create([
            'key' => 'draft-page',
            'slug' => ['en' => 'draft', 'es' => 'borrador', 'hu' => 'piszkozat'],
            'title' => ['en' => 'Draft Page', 'es' => 'Página Borrador', 'hu' => 'Vázlat Oldal'],
            'body' => ['en' => '<p>Coming soon</p>', 'es' => '<p>Próximamente</p>', 'hu' => '<p>Hamarosan</p>'],
            'is_published' => false,
            'deletable' => true,
            'sort_order' => 99,
        ]);

        $this->get('/draft')->assertNotFound();
        $this->get('/es/borrador')->assertNotFound();
    }

    // ── Dynamic page routing ─────────────────────────────────────────────────

    public function test_dynamic_page_renders_translated_body(): void
    {
        Page::create([
            'key' => 'mortgage-guide',
            'slug' => ['en' => 'mortgage-guide', 'es' => 'guia-hipotecas', 'hu' => 'jelzalog-utmutato'],
            'title' => ['en' => 'Mortgage Guide', 'es' => 'Guía de Hipotecas', 'hu' => 'Jelzálog Útmutató'],
            'body' => ['en' => '<p>English body</p>', 'es' => '<p>Cuerpo español</p>', 'hu' => '<p>Magyar tartalom</p>'],
            'is_published' => true,
            'published_at' => now(),
            'deletable' => true,
            'sort_order' => 99,
        ]);

        $this->get('/mortgage-guide')
            ->assertOk()
            ->assertSee('Mortgage Guide')
            ->assertSee('English body', false);

        $this->get('/es/guia-hipotecas')
            ->assertOk()
            ->assertSee('Guía de Hipotecas')
            ->assertSee('Cuerpo español', false);

        $this->get('/hu/jelzalog-utmutato')
            ->assertOk()
            ->assertSee('Jelzálog Útmutató');
    }

    public function test_old_locale_slug_redirects_to_canonical(): void
    {
        Page::create([
            'key' => 'redirect-test',
            'slug' => ['en' => 'redirect-test', 'es' => 'prueba-redireccion', 'hu' => 'atmutato-teszt'],
            'title' => ['en' => 'Redirect Test', 'es' => 'Prueba', 'hu' => 'Teszt'],
            'body' => ['en' => '<p>body</p>', 'es' => '<p>cuerpo</p>', 'hu' => '<p>tartalom</p>'],
            'is_published' => true,
            'published_at' => now(),
            'deletable' => true,
            'sort_order' => 99,
        ]);

        // Visiting the English slug under the Spanish prefix redirects to the canonical Spanish slug
        $this->get('/es/redirect-test')
            ->assertRedirect('/es/prueba-redireccion');
    }

    // ── Admin PageForm ────────────────────────────────────────────────────────

    public function test_admin_page_form_creates_new_page(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        Livewire::test(PageForm::class)
            ->set('form.key', 'new-guide')
            ->set('form.slug', ['en' => 'new-guide', 'es' => 'nueva-guia', 'hu' => 'uj-utmutato'])
            ->set('form.title', ['en' => 'New Guide', 'es' => 'Nueva Guía', 'hu' => 'Új Útmutató'])
            ->set('form.body', ['en' => '<p>Content</p>', 'es' => '<p>Contenido</p>', 'hu' => '<p>Tartalom</p>'])
            ->set('form.is_published', true)
            ->set('form.sort_order', 50)
            ->call('save');

        $page = Page::where('key', 'new-guide')->first();

        $this->assertNotNull($page);
        $this->assertTrue($page->is_published);
        $this->assertSame('New Guide', $page->getTranslation('title', 'en'));
        $this->assertSame('Nueva Guía', $page->getTranslation('title', 'es'));
    }

    public function test_admin_page_form_edits_existing_page(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $page = Page::create([
            'key' => 'editable-page',
            'slug' => ['en' => 'editable', 'es' => 'editable-es', 'hu' => 'editable-hu'],
            'title' => ['en' => 'Editable', 'es' => 'Editable ES', 'hu' => 'Editable HU'],
            'body' => ['en' => '<p>old</p>', 'es' => '<p>viejo</p>', 'hu' => '<p>régi</p>'],
            'is_published' => false,
            'deletable' => true,
            'sort_order' => 10,
        ]);

        Livewire::test(PageForm::class, ['page' => $page])
            ->set('form.title.en', 'Updated Title')
            ->set('form.is_published', true)
            ->call('save');

        $page->refresh();

        $this->assertSame('Updated Title', $page->getTranslation('title', 'en'));
        $this->assertTrue($page->is_published);
    }

    public function test_core_page_key_cannot_be_changed_via_admin_form(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $page = Page::where('key', 'about')->first();

        if (! $page) {
            $this->markTestSkipped('About page not seeded.');
        }

        Livewire::test(PageForm::class, ['page' => $page])
            ->set('form.key', 'hacked-key')
            ->call('save');

        $page->refresh();

        // Deletable=false pages must keep their original key
        $this->assertSame('about', $page->key);
    }

    public function test_admin_layout_exposes_csrf_token_for_livewire_uploads(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $this->get('/admin/team/create')
            ->assertOk()
            ->assertSee('name="csrf-token"', false);
    }
}
