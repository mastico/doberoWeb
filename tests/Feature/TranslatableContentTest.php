<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Admin\PageSectionsEditor;
use App\Models\PageSection;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TranslatableContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_with_spanish_translations_after_seed(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/es')
            ->assertOk()
            ->assertSee('Bienvenido a DOBERO');
    }

    public function test_homepage_renders_with_hungarian_translations_after_seed(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/hu')
            ->assertOk()
            ->assertSee('Üdvözöljük a DOBERO-nál');
    }

    public function test_page_section_editor_persists_per_locale_value(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $section = PageSection::where('page', 'home')->where('section_key', 'hero')->first();

        Livewire::test(PageSectionsEditor::class)
            ->call('selectSection', $section->id)
            ->set('form.title.es', 'Mi Título Español')
            ->set('form.title.en', $section->getTranslation('title', 'en'))
            ->call('save');

        $section->refresh();

        $this->assertSame('Mi Título Español', $section->getTranslation('title', 'es'));
        $this->assertNotEquals('Mi Título Español', $section->getTranslation('title', 'en'));
    }

    public function test_page_section_editor_saving_one_locale_does_not_overwrite_others(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $section = PageSection::where('page', 'home')->where('section_key', 'hero')->first();
        $originalEn = $section->getTranslation('title', 'en');
        $originalHu = $section->getTranslation('title', 'hu');

        Livewire::test(PageSectionsEditor::class)
            ->call('selectSection', $section->id)
            ->set('form.title.es', 'Nuevo Título')
            ->set('form.title.en', $originalEn)
            ->set('form.title.hu', $originalHu)
            ->call('save');

        $section->refresh();

        $this->assertSame($originalEn, $section->getTranslation('title', 'en'));
        $this->assertSame($originalHu, $section->getTranslation('title', 'hu'));
        $this->assertSame('Nuevo Título', $section->getTranslation('title', 'es'));
    }

    public function test_non_translatable_site_setting_returns_single_value(): void
    {
        SiteSetting::create([
            'key' => 'phone',
            'value' => ['en' => '+34600000000'],
            'type' => 'text',
            'is_translatable' => false,
        ]);

        app()->setLocale('es');

        $this->assertSame('+34600000000', SiteSetting::get('phone'));
    }

    public function test_translatable_site_setting_returns_correct_locale_value(): void
    {
        SiteSetting::create([
            'key' => 'tagline',
            'value' => ['en' => 'Your Spanish Home', 'es' => 'Tu Hogar Español', 'hu' => 'Spanyol Otthonod'],
            'type' => 'text',
            'is_translatable' => true,
        ]);

        app()->setLocale('es');

        $this->assertSame('Tu Hogar Español', SiteSetting::get('tagline'));
    }

    public function test_page_section_extra_trans_resolves_locale_value(): void
    {
        $section = PageSection::create([
            'page' => 'home',
            'section_key' => 'test_section',
            'title' => ['en' => 'Test'],
            'extra' => [
                'cta' => ['en' => 'Click here', 'es' => 'Haz clic aquí', 'hu' => 'Kattints ide'],
            ],
            'sort_order' => 99,
            'is_active' => true,
        ]);

        app()->setLocale('es');

        $this->assertSame('Haz clic aquí', $section->extraTrans('cta'));
    }
}
