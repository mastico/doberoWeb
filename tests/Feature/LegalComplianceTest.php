<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Page;
use App\Models\SiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalComplianceTest extends TestCase
{
    use RefreshDatabase;

    public function test_legal_pages_and_identity_are_seeded(): void
    {
        $this->seed(DatabaseSeeder::class);

        $legalNotice = Page::where('key', 'legal-notice')->first();
        $privacyPolicy = Page::where('key', 'privacy-policy')->first();
        $cookiePolicy = Page::where('key', 'cookie-policy')->first();

        $this->assertNotNull($legalNotice);
        $this->assertNotNull($privacyPolicy);
        $this->assertNotNull($cookiePolicy);

        $this->assertSame('legal-notice', $legalNotice->key);
        $this->assertSame('aviso-legal', $legalNotice->getTranslation('slug', 'es'));
        $this->assertSame('jogi-nyilatkozat', $legalNotice->getTranslation('slug', 'hu'));
        $this->assertSame('Aviso Legal', $legalNotice->getTranslation('title', 'es'));
        $this->assertTrue($legalNotice->is_published);
        $this->assertFalse($legalNotice->deletable);
        $this->assertStringContainsString(
            'dirección profesional indicada es provisional y está pendiente de confirmación',
            mb_strtolower($legalNotice->getTranslation('body', 'es'))
        );
        $this->assertStringContainsString('János Németh – Sole trader', $legalNotice->getTranslation('body', 'en'));
        $this->assertStringContainsString('János Németh – Autónomo', $legalNotice->getTranslation('body', 'es'));
        $this->assertStringContainsString('János Németh – Egyéni vállalkozó', $legalNotice->getTranslation('body', 'hu'));

        $this->assertSame('politica-privacidad', $privacyPolicy->getTranslation('slug', 'es'));
        $this->assertSame('Política de Privacidad', $privacyPolicy->getTranslation('title', 'es'));
        $this->assertFalse($privacyPolicy->deletable);

        $this->assertSame('politica-cookies', $cookiePolicy->getTranslation('slug', 'es'));
        $this->assertSame('Política de Cookies', $cookiePolicy->getTranslation('title', 'es'));
        $this->assertFalse($cookiePolicy->deletable);

        $this->assertSame('János Németh', SiteSetting::get('legal_owner'));
        $this->assertSame('Y1962730Q', SiteSetting::get('legal_nif'));
        $this->assertSame('DOBERO', SiteSetting::get('legal_trade_name'));
        $this->assertSame('Real estate brokerage and real estate services', SiteSetting::get('legal_activity'));
        $this->assertSame('urb.Residencial la Torre 28.', SiteSetting::get('legal_address'));
        $this->assertSame('+34 674 920 844', SiteSetting::get('phone'));
        $this->assertSame('info@dobero.es', SiteSetting::get('email'));
    }

    public function test_legal_route_segments_are_available_for_spanish_and_hungarian(): void
    {
        $spanishRoutes = require lang_path('es/routes.php');
        $hungarianRoutes = require lang_path('hu/routes.php');

        $this->assertSame('aviso-legal', $spanishRoutes['legal-notice'] ?? null);
        $this->assertSame('politica-privacidad', $spanishRoutes['privacy-policy'] ?? null);
        $this->assertSame('politica-cookies', $spanishRoutes['cookie-policy'] ?? null);

        $this->assertSame('jogi-nyilatkozat', $hungarianRoutes['legal-notice'] ?? null);
        $this->assertSame('adatvedelmi-tajekoztato', $hungarianRoutes['privacy-policy'] ?? null);
        $this->assertSame('suti-szabalyzat', $hungarianRoutes['cookie-policy'] ?? null);
    }

    public function test_legal_labels_are_available_in_all_supported_locales(): void
    {
        $expectedTranslations = [
            'en' => [
                'Legal Notice' => 'Legal Notice',
                'Privacy Policy' => 'Privacy Policy',
                'Cookie Policy' => 'Cookie Policy',
                'Cookie Settings' => 'Cookie Settings',
                'Owner' => 'Owner',
                'NIF' => 'NIF',
                'Trade name' => 'Trade name',
                'Business activity' => 'Business activity',
                'Professional address' => 'Professional address',
                'I have read and accept the Privacy Policy' => 'I have read and accept the Privacy Policy',
                'Accept' => 'Accept',
                'Reject' => 'Reject',
                'Configure' => 'Configure',
                'Necessary' => 'Necessary',
                'Analytics' => 'Analytics',
                'Marketing' => 'Marketing',
                'Save preferences' => 'Save preferences',
                'The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.' => 'The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.',
            ],
            'es' => [
                'Legal Notice' => 'Aviso Legal',
                'Privacy Policy' => 'Política de Privacidad',
                'Cookie Policy' => 'Política de Cookies',
                'Cookie Settings' => 'Configuración de Cookies',
                'Owner' => 'Titular',
                'NIF' => 'NIF',
                'Trade name' => 'Nombre comercial',
                'Business activity' => 'Actividad empresarial',
                'Professional address' => 'Dirección profesional',
                'I have read and accept the Privacy Policy' => 'He leído y acepto la Política de Privacidad',
                'Accept' => 'Aceptar',
                'Reject' => 'Rechazar',
                'Configure' => 'Configurar',
                'Necessary' => 'Necesarias',
                'Analytics' => 'Analítica',
                'Marketing' => 'Marketing',
                'Save preferences' => 'Guardar preferencias',
                'The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.' => 'La dirección profesional mostrada es provisional y está pendiente de confirmación. Sustitúyala por la dirección oficial y por un texto aprobado por asesoría jurídica antes del lanzamiento.',
            ],
            'hu' => [
                'Legal Notice' => 'Jogi nyilatkozat',
                'Privacy Policy' => 'Adatvédelmi tájékoztató',
                'Cookie Policy' => 'Cookie-szabályzat',
                'Cookie Settings' => 'Cookie-beállítások',
                'Owner' => 'Tulajdonos',
                'NIF' => 'NIF',
                'Trade name' => 'Kereskedelmi név',
                'Business activity' => 'Üzleti tevékenység',
                'Professional address' => 'Szakmai cím',
                'I have read and accept the Privacy Policy' => 'Elolvastam és elfogadom az Adatvédelmi tájékoztatót',
                'Accept' => 'Elfogadom',
                'Reject' => 'Elutasítom',
                'Configure' => 'Beállítás',
                'Necessary' => 'Szükséges',
                'Analytics' => 'Analitika',
                'Marketing' => 'Marketing',
                'Save preferences' => 'Beállítások mentése',
                'The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.' => 'A megjelenített szakmai cím megerősítésig ideiglenes. Indulás előtt cserélje le a hivatalos címre és az ügyvéd által jóváhagyott szövegre.',
            ],
        ];

        foreach ($expectedTranslations as $locale => $pairs) {
            app()->setLocale($locale);

            foreach ($pairs as $key => $expected) {
                $this->assertSame($expected, __($key), "{$locale} translation mismatch for [{$key}]");
            }
        }
    }

    public function test_legal_pages_render_on_canonical_and_localized_routes(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/legal-notice')
            ->assertOk()
            ->assertSee('Legal Notice')
            ->assertSee('Owner')
            ->assertSee('János Németh')
            ->assertSee('Y1962730Q');

        $this->get('/privacy-policy')
            ->assertOk()
            ->assertSee('Privacy Policy');

        $this->get('/cookie-policy')
            ->assertOk()
            ->assertSee('Cookie Policy');

        $this->get('/es/aviso-legal')
            ->assertOk()
            ->assertSee('Aviso Legal')
            ->assertSee('Y1962730Q')
            ->assertSee('hreflang="en" href="'.url('/legal-notice').'"', false)
            ->assertSee('hreflang="es" href="'.url('/es/aviso-legal').'"', false)
            ->assertSee('hreflang="hu" href="'.url('/hu/jogi-nyilatkozat').'"', false);

        $this->get('/hu/jogi-nyilatkozat')
            ->assertOk()
            ->assertSee('Jogi nyilatkozat');
    }

    public function test_public_footer_exposes_legal_identity_links_and_provisional_address_notice(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('© '.now()->year.' János Németh – Dobero.es - DOBERO. All rights reserved.')
            ->assertSee('Owner: János Németh')
            ->assertSee('NIF: Y1962730Q')
            ->assertSee('Business activity: Real estate brokerage and real estate services')
            ->assertSee('urb.Residencial la Torre 28.')
            ->assertSee('The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.')
            ->assertSee('href="'.url('/legal-notice').'"', false)
            ->assertSee('href="'.url('/privacy-policy').'"', false)
            ->assertSee('href="'.url('/cookie-policy').'"', false)
            ->assertSee('Cookie Settings')
            ->assertSee('dobero:open-cookie-settings')
            ->assertDontSee('Dobero S.L.');

        $this->get('/es')
            ->assertOk()
            ->assertSee('János Németh')
            ->assertSee('Y1962730Q')
            ->assertSee('DOBERO')
            ->assertSee('Aviso Legal')
            ->assertSee('Política de Privacidad')
            ->assertSee('Política de Cookies')
            ->assertSee('Cookie Settings')
            ->assertSee('La dirección profesional mostrada es provisional y está pendiente de confirmación. Sustitúyala por la dirección oficial y por un texto aprobado por asesoría jurídica antes del lanzamiento.')
            ->assertSee('href="'.url('/es/aviso-legal').'"', false)
            ->assertSee('href="'.url('/es/politica-privacidad').'"', false)
            ->assertSee('href="'.url('/es/politica-cookies').'"', false)
            ->assertDontSee('Dobero S.L.');
    }

    public function test_locale_route_returns_the_current_locale_legal_urls(): void
    {
        app()->setLocale('en');
        $this->assertSame(url('/legal-notice'), locale_route('legal-notice'));
        $this->assertSame(url('/privacy-policy'), locale_route('privacy-policy'));
        $this->assertSame(url('/cookie-policy'), locale_route('cookie-policy'));

        app()->setLocale('es');
        $this->assertSame(url('/es/aviso-legal'), locale_route('legal-notice'));
        $this->assertSame(url('/es/politica-privacidad'), locale_route('privacy-policy'));
        $this->assertSame(url('/es/politica-cookies'), locale_route('cookie-policy'));

        app()->setLocale('hu');
        $this->assertSame(url('/hu/jogi-nyilatkozat'), locale_route('legal-notice'));
        $this->assertSame(url('/hu/adatvedelmi-tajekoztato'), locale_route('privacy-policy'));
        $this->assertSame(url('/hu/suti-szabalyzat'), locale_route('cookie-policy'));
    }
}
