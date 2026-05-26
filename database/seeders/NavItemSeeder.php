<?php

namespace Database\Seeders;

use App\Models\NavItem;
use Illuminate\Database\Seeder;

class NavItemSeeder extends Seeder
{
    public function run(): void
    {
        NavItem::query()->delete();

        $items = [
            [
                'label' => ['en' => 'About Us',    'es' => 'Sobre Nosotros',  'hu' => 'Rólunk'],
                'url' => ['en' => '/about-us',       'es' => '/es/sobre-nosotros', 'hu' => '/hu/rolunk'],
                'sort_order' => 1,
                'children' => [
                    ['label' => ['en' => 'Introduction DOBERO', 'es' => 'Introducción DOBERO',    'hu' => 'DOBERO Bemutatkozó'], 'url' => ['en' => '/about-us',             'es' => '/es/sobre-nosotros',         'hu' => '/hu/rolunk'],           'sort_order' => 1],
                    ['label' => ['en' => 'Team',                'es' => 'Equipo',                 'hu' => 'Csapat'],             'url' => ['en' => '/about-us#team',        'es' => '/es/sobre-nosotros#team',    'hu' => '/hu/rolunk#team'],      'sort_order' => 2],
                    ['label' => ['en' => 'Our Partners',        'es' => 'Nuestros Socios',        'hu' => 'Partnereink'],        'url' => ['en' => '/about-us#partners',    'es' => '/es/sobre-nosotros#partners', 'hu' => '/hu/rolunk#partners'],  'sort_order' => 3],
                ],
            ],
            [
                'label' => ['en' => 'Properties',  'es' => 'Propiedades',     'hu' => 'Ingatlanok'],
                'url' => ['en' => '/properties',  'es' => '/es/propiedades', 'hu' => '/hu/ingatlanok'],
                'sort_order' => 2,
                'children' => [
                    ['label' => ['en' => 'Used Properties',            'es' => 'Propiedades de Segunda Mano', 'hu' => 'Használt Ingatlanok'],          'url' => ['en' => '/properties?status=for_sale', 'es' => '/es/propiedades?status=for_sale', 'hu' => '/hu/ingatlanok?status=for_sale'], 'sort_order' => 1],
                    ['label' => ['en' => 'New Construction Properties', 'es' => 'Obra Nueva',                  'hu' => 'Új Építésű Ingatlanok'],        'url' => ['en' => '/properties?status=new',      'es' => '/es/propiedades?status=new',      'hu' => '/hu/ingatlanok?status=new'],      'sort_order' => 2],
                    ['label' => ['en' => 'Investments',                'es' => 'Inversiones',                 'hu' => 'Befektetések'],                 'url' => ['en' => '/properties?type=investment', 'es' => '/es/propiedades?type=investment', 'hu' => '/hu/ingatlanok?type=investment'], 'sort_order' => 3],
                    ['label' => ['en' => 'Properties Buying Program',  'es' => 'Programa de Compra',          'hu' => 'Ingatlanvásárlási Program'],    'url' => ['en' => '/properties',                 'es' => '/es/propiedades',                 'hu' => '/hu/ingatlanok'],                 'sort_order' => 4],
                ],
            ],
            [
                'label' => ['en' => 'Relocation',  'es' => 'Reubicación',     'hu' => 'Költözés'],
                'url' => ['en' => '/relocation',  'es' => '/es/reubicacion', 'hu' => '/hu/koltozes'],
                'sort_order' => 3,
                'children' => [
                    ['label' => ['en' => 'Notary Power of Attorney', 'es' => 'Poder Notarial',              'hu' => 'Közjegyzői Meghatalmazás'],  'url' => ['en' => '/relocation#notary',            'es' => '/es/reubicacion#notary',            'hu' => '/hu/koltozes#notary'],            'sort_order' => 1],
                    ['label' => ['en' => 'NIE Number Processing',    'es' => 'Tramitación del NIE',         'hu' => 'NIE Szám Ügyintézés'],      'url' => ['en' => '/relocation#nie',               'es' => '/es/reubicacion#nie',               'hu' => '/hu/koltozes#nie'],               'sort_order' => 2],
                    ['label' => ['en' => 'Bank Account Opening',     'es' => 'Apertura de Cuenta Bancaria', 'hu' => 'Bankszámla Nyitás'],        'url' => ['en' => '/relocation#bank',              'es' => '/es/reubicacion#bank',              'hu' => '/hu/koltozes#bank'],              'sort_order' => 3],
                    ['label' => ['en' => 'Address Notification',     'es' => 'Empadronamiento',             'hu' => 'Lakcímbejelentés'],         'url' => ['en' => '/relocation#address',           'es' => '/es/reubicacion#address',           'hu' => '/hu/koltozes#address'],           'sort_order' => 4],
                    ['label' => ['en' => 'European Residency',       'es' => 'Residencia Europea',          'hu' => 'Európai Tartózkodási Engedély'], 'url' => ['en' => '/relocation#residency',       'es' => '/es/reubicacion#residency',         'hu' => '/hu/koltozes#residency'],         'sort_order' => 5],
                    ['label' => ['en' => 'Digital Signature',        'es' => 'Firma Digital',               'hu' => 'Digitális Aláírás'],        'url' => ['en' => '/relocation#digital-signature', 'es' => '/es/reubicacion#digital-signature', 'hu' => '/hu/koltozes#digital-signature'], 'sort_order' => 6],
                    ['label' => ['en' => 'Public Transcript',        'es' => 'Certificado Público',         'hu' => 'Közokirati Kivonat'],       'url' => ['en' => '/relocation#transcript',        'es' => '/es/reubicacion#transcript',        'hu' => '/hu/koltozes#transcript'],        'sort_order' => 7],
                ],
            ],
            [
                'label' => ['en' => 'Construction', 'es' => 'Construcción',    'hu' => 'Építkezés'],
                'url' => ['en' => '/construction', 'es' => '/es/construccion', 'hu' => '/hu/epitkezes'],
                'sort_order' => 4,
                'children' => [
                    ['label' => ['en' => 'General Construction', 'es' => 'Construcción General', 'hu' => 'Általános Építkezés'],  'url' => ['en' => '/construction',                   'es' => '/es/construccion',                   'hu' => '/hu/epitkezes'],                   'sort_order' => 1],
                    ['label' => ['en' => 'Refurbishment',        'es' => 'Rehabilitación',       'hu' => 'Felújítás'],           'url' => ['en' => '/construction#refurbishment',     'es' => '/es/construccion#refurbishment',     'hu' => '/hu/epitkezes#refurbishment'],     'sort_order' => 2],
                    ['label' => ['en' => 'Permit Acquisition',   'es' => 'Obtención de Permisos', 'hu' => 'Engedélyszerzés'],   'url' => ['en' => '/construction#permit-acquisition', 'es' => '/es/construccion#permit-acquisition', 'hu' => '/hu/epitkezes#permit-acquisition'], 'sort_order' => 3],
                    ['label' => ['en' => 'References',           'es' => 'Referencias',          'hu' => 'Referenciák'],        'url' => ['en' => '/construction#references',        'es' => '/es/construccion#references',        'hu' => '/hu/epitkezes#references'],        'sort_order' => 4],
                ],
            ],
            [
                'label' => ['en' => 'Specials', 'es' => 'Ofertas',   'hu' => 'Ajánlatok'],
                'url' => ['en' => '/specials', 'es' => '/es/ofertas', 'hu' => '/hu/ajanlatok'],
                'sort_order' => 5,
                'children' => [
                    ['label' => ['en' => 'Technical Condition Assessment', 'es' => 'Evaluación del Estado Técnico', 'hu' => 'Műszaki Állapotfelmérés'],  'url' => ['en' => '/specials#assessment',     'es' => '/es/ofertas#assessment',     'hu' => '/hu/ajanlatok#assessment'],     'sort_order' => 1],
                    ['label' => ['en' => 'Discovery of Hidden Defects',   'es' => 'Detección de Defectos Ocultos', 'hu' => 'Rejtett Hibák Feltárása'], 'url' => ['en' => '/specials#hidden-defects', 'es' => '/es/ofertas#hidden-defects', 'hu' => '/hu/ajanlatok#hidden-defects'], 'sort_order' => 2],
                    ['label' => ['en' => 'Waterproofing Solutions',        'es' => 'Soluciones de Impermeabilización', 'hu' => 'Vízszigetelésen Megoldások'], 'url' => ['en' => '/specials#waterproofing', 'es' => '/es/ofertas#waterproofing',  'hu' => '/hu/ajanlatok#waterproofing'],  'sort_order' => 3],
                    ['label' => ['en' => 'Forensic Expert Support',        'es' => 'Apoyo Pericial Forense',        'hu' => 'Szakértői Igazságügyi Támogatás'], 'url' => ['en' => '/specials#forensics', 'es' => '/es/ofertas#forensics',      'hu' => '/hu/ajanlatok#forensics'],      'sort_order' => 4],
                ],
            ],
        ];

        foreach ($items as $itemData) {
            $children = $itemData['children'] ?? [];
            unset($itemData['children']);

            $item = new NavItem;
            $item->sort_order = $itemData['sort_order'];
            $item->location = 'primary';
            $item->is_active = true;
            $item->opens_in_new_tab = false;
            $item->setTranslations('label', $itemData['label']);
            $item->setTranslations('url', $itemData['url']);
            $item->save();

            foreach ($children as $childData) {
                $child = new NavItem;
                $child->parent_id = $item->id;
                $child->location = 'primary';
                $child->sort_order = $childData['sort_order'];
                $child->is_active = true;
                $child->opens_in_new_tab = false;
                $child->setTranslations('label', $childData['label']);
                $child->setTranslations('url', $childData['url']);
                $child->save();
            }
        }
    }
}
