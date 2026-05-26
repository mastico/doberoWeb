<?php

namespace Tests\Feature;

use App\Models\Page;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizedPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_pages_use_translated_paths_and_hreflang_links(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/es/sobre-nosotros')
            ->assertOk()
            ->assertSee('Sobre Nosotros')
            ->assertSee('hreflang="en" href="'.url('/about-us').'"', false)
            ->assertSee('hreflang="es" href="'.url('/es/sobre-nosotros').'"', false)
            ->assertSee('hreflang="hu" href="'.url('/hu/rolunk').'"', false);

        $this->get('/hu/epitkezes')
            ->assertOk()
            ->assertSee('Építkezés');
    }

    public function test_dynamic_pages_resolve_translated_slugs(): void
    {
        Page::create([
            'key' => 'investor-guide',
            'slug' => ['en' => 'investor-guide', 'es' => 'guia-inversor', 'hu' => 'befektetoi-utmutato'],
            'title' => ['en' => 'Investor Guide', 'es' => 'Guía del Inversor', 'hu' => 'Befektetői Útmutató'],
            'body' => ['en' => '<p>English body</p>', 'es' => '<p>Cuerpo español</p>', 'hu' => '<p>Magyar tartalom</p>'],
            'meta_title' => ['en' => 'Investor Guide', 'es' => 'Guía del Inversor', 'hu' => 'Befektetői Útmutató'],
            'meta_description' => ['en' => 'Guide', 'es' => 'Guía', 'hu' => 'Útmutató'],
            'is_published' => true,
            'published_at' => now(),
            'deletable' => true,
            'sort_order' => 99,
        ]);

        $this->get('/es/guia-inversor')
            ->assertOk()
            ->assertSee('Guía del Inversor')
            ->assertSee('hreflang="en" href="'.url('/investor-guide').'"', false)
            ->assertSee('hreflang="hu" href="'.url('/hu/befektetoi-utmutato').'"', false);

        $this->get('/hu/investor-guide')
            ->assertRedirect('/hu/befektetoi-utmutato');
    }
}
