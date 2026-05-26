<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'page' => 'home',
                'section_key' => 'hero',
                'title' => ['en' => 'Welcome to DOBERO', 'es' => 'Bienvenido a DOBERO', 'hu' => 'Üdvözöljük a DOBERO-nál'],
                'subtitle' => ['en' => 'The DOBERO team is who realize your spanish home! The key to your spanish home is here with us! Come and pick it up!', 'es' => '¡El equipo DOBERO es quien realiza tu hogar español! ¡La llave de tu hogar español está aquí con nosotros!', 'hu' => 'A DOBERO csapata valósítja meg az ön spanyol otthonát! A kulcs az ön spanyol otthonához itt van nálunk!'],
                'content' => ['en' => 'Fully aware of our responsibility, we help you find or refurbish your home in Spain with personalized services.', 'es' => 'Plenamente conscientes de nuestra responsabilidad, te ayudamos a encontrar o reformar tu hogar en España con servicios personalizados.', 'hu' => 'Felelősségünk teljes tudatában segítünk megtalálni vagy felújítani otthonát Spanyolországban személyre szabott szolgáltatásokkal.'],
                'extra' => [
                    'hero_image' => null,
                    'primary_cta' => ['label' => ['en' => 'Explore Properties', 'es' => 'Explorar Propiedades', 'hu' => 'Ingatlanok Böngészése'], 'route' => 'properties.index'],
                    'secondary_cta' => ['label' => ['en' => 'Talk To Our Team', 'es' => 'Hablar Con Nuestro Equipo', 'hu' => 'Kapcsolat a Csapattal'], 'route' => 'contact'],
                    'pillars' => [
                        ['label' => ['en' => 'Our Mission', 'es' => 'Nuestra Misión', 'hu' => 'Küldetésünk'], 'body' => ['en' => 'Fully aware of our responsibility, we help you find or refurbish your home in Spain with personalized services.', 'es' => 'Plenamente conscientes de nuestra responsabilidad, te ayudamos a encontrar o reformar tu hogar en España.', 'hu' => 'Felelősségünk teljes tudatában segítünk megtalálni vagy felújítani otthonát Spanyolországban.']],
                        ['label' => ['en' => 'Our Vision', 'es' => 'Nuestra Visión', 'hu' => 'Jövőképünk'], 'body' => ['en' => 'Through innovation to achieve a dominant position on the market. Providing the best services to our Customers.', 'es' => 'A través de la innovación para lograr una posición dominante en el mercado. Proporcionando los mejores servicios.', 'hu' => 'Innováció révén vezető pozíció elérése a piacon, a legjobb szolgáltatásokkal.']],
                        ['label' => ['en' => 'Are You Ready?', 'es' => '¿Estás Listo?', 'hu' => 'Készen Áll?'], 'body' => ['en' => 'To start your life in Spain, whether in a city on the peninsula, or in Ibiza or one of the other Spanish islands.', 'es' => 'Para comenzar tu vida en España, ya sea en la península o en una de las islas españolas.', 'hu' => 'Hogy megkezdje életét Spanyolországban, akár a félszigeten, akár a szigeteken.']],
                    ],
                ],
                'sort_order' => 1,
            ],
            [
                'page' => 'home',
                'section_key' => 'mission',
                'title' => ['en' => 'Built on trust, insight, and action', 'es' => 'Construido sobre confianza, visión y acción', 'hu' => 'Bizalomra, meglátásra és cselekvésre építve'],
                'extra' => [
                    'stats' => [
                        ['icon' => 'nie', 'label' => ['en' => 'NIE Number', 'es' => 'Número NIE', 'hu' => 'NIE Szám'], 'value' => '24-48H'],
                        ['icon' => 'mortgage', 'label' => ['en' => 'Mortgage Up To', 'es' => 'Hipoteca Hasta', 'hu' => 'Jelzálog Akár'], 'value' => '80%'],
                        ['icon' => 'building', 'label' => ['en' => 'Building Pathology', 'es' => 'Patología de Edificios', 'hu' => 'Épületpatológia'], 'value' => '40+'],
                        ['icon' => 'search', 'label' => ['en' => 'Finding Hidden Errors', 'es' => 'Encontrando Errores Ocultos', 'hu' => 'Rejtett Hibák Feltárása'], 'value' => '€0'],
                    ],
                ],
                'sort_order' => 2,
            ],
            [
                'page' => 'home',
                'section_key' => 'expertise',
                'title' => ['en' => 'Real Estate Expertise For Over 40 Years', 'es' => 'Experiencia Inmobiliaria Por Más de 40 Años', 'hu' => 'Több Mint 40 Éves Ingatlanpiaci Tapasztalat'],
                'content' => ['en' => 'We combine estate agency, relocation consulting, building pathology, financing guidance, and local market intelligence. That means fewer surprises and faster decisions for local and international buyers alike.', 'es' => 'Combinamos agencia inmobiliaria, consultoría de reubicación, patología de edificios, orientación financiera e inteligencia local de mercado.', 'hu' => 'Ötvözzük az ingatlanközvetítést, a költözési tanácsadást, az épületpatológiát és a finanszírozási útmutatást.'],
                'extra' => [
                    'button_label' => ['en' => 'Learn More', 'es' => 'Saber Más', 'hu' => 'Tudjon Meg Többet'],
                    'button_url' => '/about-us',
                ],
                'sort_order' => 3,
            ],
            [
                'page' => 'home',
                'section_key' => 'services_banner',
                'title' => ['en' => 'We Represent And Assist You Everywhere', 'es' => 'Le Representamos y Asistimos en Todas Partes', 'hu' => 'Mindenhol Képviseljük és Segítjük Önt'],
                'subtitle' => ['en' => 'Focused support services that save time, reduce risk, and protect your investment.', 'es' => 'Servicios de apoyo enfocados que ahorran tiempo, reducen riesgos y protegen su inversión.', 'hu' => 'Célzott támogatási szolgáltatások, amelyek időt takarítanak meg és védik befektetését.'],
                'extra' => [
                    'image' => null,
                    'items' => [
                        ['icon' => 'home', 'title' => ['en' => 'Buy', 'es' => 'Comprar', 'hu' => 'Vásárlás'], 'caption' => ['en' => 'Curated listings', 'es' => 'Propiedades seleccionadas', 'hu' => 'Válogatott ajánlatok']],
                        ['icon' => 'tag', 'title' => ['en' => 'Sell', 'es' => 'Vender', 'hu' => 'Eladás'], 'caption' => ['en' => 'Valuation & match', 'es' => 'Valoración y encaje', 'hu' => 'Értékbecslés és párosítás']],
                        ['icon' => 'key', 'title' => ['en' => 'Rent', 'es' => 'Alquilar', 'hu' => 'Bérlés'], 'caption' => ['en' => 'Long & short term', 'es' => 'Largo y corto plazo', 'hu' => 'Hosszú és rövid táv']],
                        ['icon' => 'wrench', 'title' => ['en' => 'Build', 'es' => 'Construir', 'hu' => 'Építés'], 'caption' => ['en' => 'Construct & finish', 'es' => 'Construir y terminar', 'hu' => 'Kivitelezés és befejezés']],
                    ],
                ],
                'sort_order' => 4,
            ],
            [
                'page' => 'home',
                'section_key' => 'investment',
                'title' => ['en' => 'You Can Find Your Perfect Investment', 'es' => 'Puede Encontrar Su Inversión Perfecta', 'hu' => 'Megtalálhatja Tökéletes Befektetését'],
                'content' => ['en' => 'Browse a portfolio of contemporary apartments, sea-view villas, and value-add properties selected for location quality, resale potential, and renovation upside.', 'es' => 'Explore una cartera de apartamentos contemporáneos, villas con vistas al mar y propiedades con potencial de revalorización.', 'hu' => 'Fedezze fel a kortárs lakások, tengeri panorámás villák és értéknövelő ingatlanok portfólióját.'],
                'extra' => [
                    'button_label' => ['en' => 'View Properties', 'es' => 'Ver Propiedades', 'hu' => 'Ingatlanok Megtekintése'],
                    'button_url' => '/properties',
                    'images' => [],
                    'bullets' => [
                        ['en' => 'Complete Documentation', 'es' => 'Documentación Completa', 'hu' => 'Teljes Dokumentáció'],
                        ['en' => 'Transferring Utility Meters', 'es' => 'Transferencia de Suministros', 'hu' => 'Közműórák Átírása'],
                        ['en' => 'Redesigning Property', 'es' => 'Rediseño de la Propiedad', 'hu' => 'Ingatlan Újratervezése'],
                        ['en' => 'Obtain All The Licences', 'es' => 'Obtener Todas las Licencias', 'hu' => 'Minden Engedély Beszerzése'],
                        ['en' => 'Refurbishment', 'es' => 'Reforma', 'hu' => 'Felújítás'],
                    ],
                ],
                'sort_order' => 5,
            ],
            [
                'page' => 'home',
                'section_key' => 'contact',
                'title' => ['en' => 'Please Write To Us', 'es' => 'Por Favor Escríbanos', 'hu' => 'Kérjük Írjon Nekünk'],
                'content' => ['en' => "If you are looking for a property or if you need any refurbishment!\n\nOr — if you want to be your own boss, build your career with us. As a marketing worker you can post our properties, represent us in your country, and receive a 50% commission for every property sold.", 'es' => "¡Si está buscando una propiedad o si necesita alguna reforma!\n\nO — si quiere ser su propio jefe, construya su carrera con nosotros.", 'hu' => "Ha ingatlant keres vagy felújításra van szüksége!\n\nVagy ha saját főnöke szeretne lenni, építse karrierjét velünk."],
                'sort_order' => 6,
            ],
            [
                'page' => 'home',
                'section_key' => 'featured_grid',
                'title' => ['en' => 'Display Different Content Types', 'es' => 'Mostrar Diferentes Tipos de Contenido', 'hu' => 'Különböző Tartalomtípusok Megjelenítése'],
                'subtitle' => ['en' => 'Explore featured homes, build-ready plots, and rental opportunities.', 'es' => 'Explore casas destacadas, parcelas listas para construir y oportunidades de alquiler.', 'hu' => 'Fedezze fel a kiemelt otthonokat, az építésre kész telkeket és a bérlési lehetőségeket.'],
                'extra' => [
                    'categories' => ['House', 'Flat', 'Detached Villa', 'Semi-detached', 'Duplex', 'Penthouse', 'Study', 'Bungalow', 'Country House'],
                ],
                'sort_order' => 7,
            ],
            [
                'page' => 'home',
                'section_key' => 'agents',
                'title' => ['en' => 'We are here to help you!', 'es' => '¡Estamos aquí para ayudarle!', 'hu' => 'Itt vagyunk, hogy segítsünk!'],
                'subtitle' => ['en' => 'Meet the professionals behind your search, transaction, and project delivery.', 'es' => 'Conozca a los profesionales detrás de su búsqueda, transacción y entrega de proyectos.', 'hu' => 'Ismerje meg a keresés és projektmegvalósítás mögötti szakembereket.'],
                'sort_order' => 8,
            ],
            [
                'page' => 'home',
                'section_key' => 'testimonials',
                'title' => ['en' => 'Testimonials', 'es' => 'Testimonios', 'hu' => 'Vélemények'],
                'sort_order' => 9,
            ],
            [
                'page' => 'home',
                'section_key' => 'partners',
                'title' => ['en' => 'Trusted By Outstanding Partners', 'es' => 'Con la Confianza de Socios Destacados', 'hu' => 'Kiemelkedő Partnerek Bizalmával'],
                'extra' => [
                    'logos' => ['Idealista', 'Fotocasa', 'Habitaclia', 'Kyero', 'Rightmove'],
                ],
                'sort_order' => 10,
            ],
            [
                'page' => 'about',
                'section_key' => 'header',
                'title' => ['en' => 'About Us', 'es' => 'Sobre Nosotros', 'hu' => 'Rólunk'],
                'subtitle' => ['en' => "The DOBERO team offers more than just a 'property in Spain'!", 'es' => "¡El equipo DOBERO ofrece mucho más que una simple 'propiedad en España'!", 'hu' => 'A DOBERO csapata többet kínál, mint pusztán egy spanyol ingatlant!'],
                'sort_order' => 1,
            ],
            [
                'page' => 'about',
                'section_key' => 'intro',
                'title' => ['en' => 'WE CREATE NEW LIFES AND NEW HOMES ON THE COSTA BLANCA!', 'es' => '¡CREAMOS NUEVAS VIDAS Y NUEVOS HOGARES EN LA COSTA BLANCA!', 'hu' => 'ÚJ ÉLETEKET ÉS ÚJ OTTHONOKAT TEREMTÜNK A COSTA BLANCÁN!'],
                'content' => ['en' => 'Our logo symbolizes enduring strength and deep roots. Our experience ensures we are a steadfast partner while you create your new life and home in Spain.', 'es' => 'Nuestro logo simboliza fortaleza duradera y raíces profundas. Nuestra experiencia garantiza que seremos un socio firme en su nueva vida en España.', 'hu' => 'Logónk tartós erőt és mély gyökereket jelképez. Tapasztalatunk biztosítja, hogy megbízható partnerek legyünk új spanyol életében.'],
                'extra' => [
                    'column_two' => ['en' => 'We understand that moving to a new country is a huge decision. Our multilingual team creates personalized plans around each client’s goals.', 'es' => 'Entendemos que mudarse a un nuevo país es una gran decisión. Nuestro equipo multilingüe crea planes personalizados.', 'hu' => 'Megértjük, hogy új országba költözni nagy döntés. Többnyelvű csapatunk személyre szabott terveket készít.'],
                ],
                'sort_order' => 2,
            ],
            [
                'page' => 'about',
                'section_key' => 'keywords',
                'title' => ['en' => 'What We Stand For', 'es' => 'Lo Que Representamos', 'hu' => 'Amit Képviselünk'],
                'extra' => [
                    'cards' => [
                        'en' => [
                            ['word' => 'Destinations',  'desc' => 'Discover your perfect destination'],
                            ['word' => 'Oasis',         'desc' => 'Your oasis of tranquility'],
                            ['word' => 'Breeze',        'desc' => 'Seamless and stress-free process'],
                            ['word' => 'Elegance',      'desc' => 'Elegant properties, sophisticated service'],
                            ['word' => 'Retreat',       'desc' => 'Your perfect coastal retreat'],
                            ['word' => 'Outstanding',   'desc' => 'Outstanding service and results'],
                        ],
                        'hu' => [
                            ['word' => 'Döntés',        'desc' => 'Segítünk a legjobb döntés meghozatalában'],
                            ['word' => 'Otthonod',      'desc' => 'Az Ön álmai otthona a Costa Blancán'],
                            ['word' => 'Bizalom',       'desc' => 'Megbízható szolgáltatások szakértői csapatunktól'],
                            ['word' => 'Előnyök',       'desc' => 'Díjmentes dokumentáció az ingatlanvásárláshoz, kiváló szolgáltatások'],
                            ['word' => 'Relaxáció',     'desc' => 'Stresszmentes ügyintézés'],
                            ['word' => 'Oázis',         'desc' => 'Nyugalom, kényelem, a Costa Blanca oázisa'],
                        ],
                        'es' => [
                            ['word' => 'Destinos',      'desc' => 'Destinos de ensueño en la Costa Blanca'],
                            ['word' => 'Oportunidad',   'desc' => 'Oportunidad de inversión única'],
                            ['word' => 'Bienestar',     'desc' => 'Bienestar y tranquilidad en tu nuevo hogar'],
                            ['word' => 'Elegantes',     'desc' => 'Elegantes propiedades, servicio sofisticado'],
                            ['word' => 'Refugio',       'desc' => 'Tu refugio costero perfecto'],
                            ['word' => 'Optimo',        'desc' => 'Servicio óptimo y resultados excepcionales'],
                        ],
                    ],
                ],
                'sort_order' => 3,
            ],
            ['page' => 'about', 'section_key' => 'team', 'title' => ['en' => 'Meet our Team', 'es' => 'Conoce a Nuestro Equipo', 'hu' => 'Ismerje Meg Csapatunkat'], 'subtitle' => ['en' => 'Experienced specialists in real estate, law, architecture, construction, and client services.', 'es' => 'Especialistas en bienes raíces, derecho, arquitectura, construcción y atención al cliente.', 'hu' => 'Tapasztalt szakemberek az ingatlan, jogi, építészeti, kivitelezési és ügyfélszolgálati területen.'], 'sort_order' => 4],
            ['page' => 'about', 'section_key' => 'testimonials', 'title' => ['en' => 'Testimonials', 'es' => 'Testimonios', 'hu' => 'Vélemények'], 'sort_order' => 5],
            [
                'page' => 'about',
                'section_key' => 'partners',
                'title' => ['en' => 'Our Partners', 'es' => 'Nuestros Socios', 'hu' => 'Partnereink'],
                'subtitle' => ['en' => 'Trusted companies and professionals we work with on the Costa Blanca.', 'es' => 'Empresas y profesionales de confianza con quienes colaboramos en la Costa Blanca.', 'hu' => 'Megbízható cégek és szakemberek, akikkel a Costa Blancán együtt dolgozunk.'],
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::updateOrCreate(
                ['page' => $section['page'], 'section_key' => $section['section_key']],
                [
                    'title' => $section['title'] ?? null,
                    'subtitle' => $section['subtitle'] ?? null,
                    'content' => $section['content'] ?? null,
                    'extra' => $section['extra'] ?? null,
                    'sort_order' => $section['sort_order'] ?? 0,
                    'is_active' => true,
                ]
            );
        }
    }
}
