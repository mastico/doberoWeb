<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'key' => 'about',
                'slug' => ['en' => 'about-us', 'es' => 'sobre-nosotros', 'hu' => 'rolunk'],
                'title' => ['en' => 'About Us', 'es' => 'Sobre Nosotros', 'hu' => 'Rólunk'],
                'body' => ['en' => '<p>DOBERO supports international buyers with property sourcing, relocation guidance, construction planning, and trusted local insight across Spain.</p>', 'es' => '<p>DOBERO apoya a compradores internacionales con búsqueda de propiedades, asesoramiento en reubicación, planificación de construcción y experiencia local.</p>', 'hu' => '<p>A DOBERO támogatja a nemzetközi vásárlókat ingatlankereséssel, költözési tanácsadással és helyi szakértelemmel Spanyolországban.</p>'],
                'meta_title' => ['en' => 'About DOBERO', 'es' => 'Sobre DOBERO', 'hu' => 'A DOBERO-ról'],
                'meta_description' => ['en' => 'Learn about DOBERO and its real estate, relocation, and construction services in Spain.', 'es' => 'Conozca DOBERO y sus servicios inmobiliarios, de reubicación y construcción en España.', 'hu' => 'Ismerje meg a DOBERO ingatlanos, költözési és építési szolgáltatásait Spanyolországban.'],
                'sort_order' => 1,
                'deletable' => false,
            ],
            [
                'key' => 'contact',
                'slug' => ['en' => 'contact', 'es' => 'contacto', 'hu' => 'kapcsolat'],
                'title' => ['en' => 'Contact', 'es' => 'Contacto', 'hu' => 'Kapcsolat'],
                'body' => ['en' => '<p>Tell us what you are searching for and our team will prepare the next best steps.</p>', 'es' => '<p>Cuéntenos qué está buscando y nuestro equipo preparará los siguientes pasos.</p>', 'hu' => '<p>Ossza meg velünk céljait, és csapatunk előkészíti a következő lépéseket.</p>'],
                'meta_title' => ['en' => 'Contact DOBERO', 'es' => 'Contactar con DOBERO', 'hu' => 'Kapcsolat a DOBERO-val'],
                'meta_description' => ['en' => 'Get in touch with DOBERO.', 'es' => 'Póngase en contacto con DOBERO.', 'hu' => 'Vegye fel a kapcsolatot a DOBERO csapatával.'],
                'sort_order' => 2,
                'deletable' => false,
            ],
            [
                'key' => 'relocation',
                'slug' => ['en' => 'relocation', 'es' => 'reubicacion', 'hu' => 'koltozes'],
                'title' => ['en' => 'Relocation', 'es' => 'Reubicación', 'hu' => 'Költözés'],
                'body' => ['en' => '<p>Move to Spain with confidence through practical support for residency, utilities, schools, and settling in.</p>', 'es' => '<p>Múdese a España con confianza con apoyo práctico para residencia, suministros, colegios y adaptación.</p>', 'hu' => '<p>Költözzön Spanyolországba magabiztosan gyakorlati támogatással a letelepedés minden szakaszában.</p>'],
                'meta_title' => ['en' => 'Relocation Services', 'es' => 'Servicios de Reubicación', 'hu' => 'Költözési Szolgáltatások'],
                'meta_description' => ['en' => 'Relocation support for moving to Spain.', 'es' => 'Apoyo de reubicación para mudarse a España.', 'hu' => 'Költözési támogatás Spanyolországba költözéshez.'],
                'sort_order' => 3,
                'deletable' => false,
            ],
            [
                'key' => 'construction',
                'slug' => ['en' => 'construction', 'es' => 'construccion', 'hu' => 'epitkezes'],
                'title' => ['en' => 'Construction', 'es' => 'Construcción', 'hu' => 'Építkezés'],
                'body' => ['en' => '<p>From pathology reviews to refurbishment delivery, we coordinate trusted professionals for your property project.</p>', 'es' => '<p>Desde revisiones técnicas hasta la entrega de reformas, coordinamos profesionales de confianza para su proyecto.</p>', 'hu' => '<p>A műszaki felméréstől a felújítás átadásáig megbízható szakembereket koordinálunk projektjéhez.</p>'],
                'meta_title' => ['en' => 'Construction Services', 'es' => 'Servicios de Construcción', 'hu' => 'Építési Szolgáltatások'],
                'meta_description' => ['en' => 'Construction and refurbishment support for Spanish properties.', 'es' => 'Apoyo en construcción y reformas para propiedades en España.', 'hu' => 'Építési és felújítási támogatás spanyol ingatlanokhoz.'],
                'sort_order' => 4,
                'deletable' => false,
            ],
            [
                'key' => 'specials',
                'slug' => ['en' => 'specials', 'es' => 'ofertas', 'hu' => 'ajanlatok'],
                'title' => ['en' => 'Specials', 'es' => 'Ofertas', 'hu' => 'Ajánlatok'],
                'body' => ['en' => '<p>Discover curated opportunities, featured homes, and investment-led property selections.</p>', 'es' => '<p>Descubra oportunidades seleccionadas, viviendas destacadas y propiedades pensadas para inversión.</p>', 'hu' => '<p>Fedezze fel a válogatott lehetőségeket, kiemelt otthonokat és befektetési ajánlatokat.</p>'],
                'meta_title' => ['en' => 'Special Property Opportunities', 'es' => 'Oportunidades Especiales', 'hu' => 'Különleges Lehetőségek'],
                'meta_description' => ['en' => 'Featured property opportunities from DOBERO.', 'es' => 'Oportunidades destacadas de DOBERO.', 'hu' => 'A DOBERO kiemelt ingatlanlehetőségei.'],
                'sort_order' => 5,
                'deletable' => false,
            ],
        ];

        foreach ($pages as $pageData) {
            $page = Page::firstOrNew(['key' => $pageData['key']]);
            $page->is_published = true;
            $page->published_at = $page->published_at ?? now();
            $page->deletable = $pageData['deletable'];
            $page->sort_order = $pageData['sort_order'];
            $page->setTranslations('slug', $pageData['slug']);
            $page->setTranslations('title', $pageData['title']);
            $page->setTranslations('body', $pageData['body']);
            $page->setTranslations('meta_title', $pageData['meta_title']);
            $page->setTranslations('meta_description', $pageData['meta_description']);
            $page->save();
        }
    }
}
