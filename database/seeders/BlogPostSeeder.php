<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'slug' => 'five-things-every-overseas-buyer-should-check',
                'title' => ['en' => 'Five Things Every Overseas Buyer Should Check Before Reserving a Property', 'es' => 'Cinco Cosas que Todo Comprador Extranjero Debe Verificar Antes de Reservar una Propiedad', 'hu' => 'Öt Dolog, Amit Minden Külföldi Vevőnek Ellenőriznie Kell Ingatlanfoglalás Előtt'],
                'excerpt' => ['en' => 'A practical checklist covering legal review, hidden defects, financing preparation, and neighborhood due diligence.', 'es' => 'Una lista de verificación práctica que cubre revisión legal, defectos ocultos, preparación financiera y diligencia debida del vecindario.', 'hu' => 'Gyakorlati ellenőrzőlista a jogi áttekintésről, rejtett hibákról, finanszírozási előkészítésről és a szomszédság átvilágításáról.'],
                'content' => ['en' => 'Buying abroad becomes much easier when you understand local paperwork, likely refurbishment costs, and the true ownership timeline. In this guide we explain how to evaluate legal status, technical reports, budget buffers, and financing capacity before you commit.', 'es' => 'Comprar en el extranjero se vuelve mucho más fácil cuando entiendes los trámites locales, los probables costes de reforma y el plazo real de propiedad. En esta guía explicamos cómo evaluar el estado legal, los informes técnicos, los márgenes de presupuesto y la capacidad financiera antes de comprometerte.', 'hu' => 'A külföldi vásárlás sokkal egyszerűbbé válik, ha megérted a helyi papírmunkát, a várható felújítási költségeket és a tényleges tulajdonosi ütemtervet. Ebben az útmutatóban elmagyarázzuk, hogyan értékeld a jogi státuszt, a műszaki jelentéseket, a költségvetési tartalékokat és a finanszírozási kapacitást a kötelezettségvállalás előtt.'],
                'image' => '/images/defaults/blog-1.jpg',
                'category' => 'Buying Guide',
                'author' => 'Janos Nemeth',
                'published_at' => now()->subDays(21),
            ],
            [
                'slug' => 'how-building-pathology-reports-protect-investors',
                'title' => ['en' => 'How Building Pathology Reports Protect Real Estate Investors', 'es' => 'Cómo los Informes de Patología de Edificios Protegen a los Inversores Inmobiliarios', 'hu' => 'Hogyan Védi az Épületpatológiai Jelentés az Ingatlanbefektetőket'],
                'excerpt' => ['en' => 'Structural, moisture, and systems assessments can reveal the hidden costs that photos never show.', 'es' => 'Las evaluaciones estructurales, de humedad y de sistemas pueden revelar los costes ocultos que las fotos nunca muestran.', 'hu' => 'A szerkezeti, nedvességi és rendszer-értékelések feltárhatják azokat a rejtett költségeket, amelyeket a fotók soha nem mutatnak.'],
                'content' => ['en' => 'Before acquiring a resale home or distressed asset, a technical inspection offers leverage and clarity. We outline the most common red flags and how early diagnosis helps you negotiate smarter.', 'es' => 'Antes de adquirir una vivienda de reventa o un activo en dificultades, una inspección técnica ofrece apalancamiento y claridad. Describimos las señales de alerta más comunes y cómo el diagnóstico temprano te ayuda a negociar mejor.', 'hu' => 'Viszonteladó otthon vagy nehéz helyzetű eszköz megszerzése előtt a műszaki vizsgálat tőkeáttételt és egyértelműséget kínál. Felvázoljuk a leggyakoribb figyelmeztető jeleket és hogyan segít a korai diagnózis okosabban tárgyalni.'],
                'image' => '/images/defaults/blog-2.jpg',
                'category' => 'Construction',
                'author' => 'Keith Ratley',
                'published_at' => now()->subDays(14),
            ],
            [
                'slug' => 'relocating-to-the-spanish-coast',
                'title' => ['en' => 'Relocating to the Spanish Coast: Documents, Timelines, and First Steps', 'es' => 'Mudarse a la Costa Española: Documentos, Plazos y Primeros Pasos', 'hu' => 'Költözés a Spanyol Partra: Dokumentumok, Ütemtervek és Első Lépések'],
                'excerpt' => ['en' => 'From NIE numbers to banking and utility setup, here is how to reduce stress during your move.', 'es' => 'Desde los números NIE hasta la apertura de cuentas bancarias y la configuración de servicios, así es como reducir el estrés durante tu mudanza.', 'hu' => 'A NIE-számoktól a banki és közüzemi beállításig, így csökkentsd a stresszt a költözés során.'],
                'content' => ['en' => 'Relocation requires organization across identity documents, schools, healthcare, and utility connections. This article breaks the process into manageable steps for smoother transitions.', 'es' => 'La reubicación requiere organización en documentos de identidad, escuelas, sanidad y conexiones de servicios. Este artículo divide el proceso en pasos manejables para transiciones más fluidas.', 'hu' => 'A költözés szervezést igényel a személyazonossági dokumentumok, iskolák, egészségügy és közüzemi kapcsolatok terén. Ez a cikk kezelhető lépésekre bontja a folyamatot a simább átmenetekért.'],
                'image' => '/images/defaults/blog-3.jpg',
                'category' => 'Relocation',
                'author' => 'Danielle Murray',
                'published_at' => now()->subDays(10),
            ],
            [
                'slug' => 'spotting-underrated-neighborhoods-for-long-term-growth',
                'title' => ['en' => 'Where Value Lives: Spotting Underrated Neighborhoods for Long-Term Growth', 'es' => 'Dónde Vive el Valor: Detectar Vecindarios Infravalorados para el Crecimiento a Largo Plazo', 'hu' => 'Hol Él az Érték: Alulértékelt Kerületek Felismerése Hosszú Távú Növekedésre'],
                'excerpt' => ['en' => 'A look at the indicators we track when searching for properties with resilient upside.', 'es' => 'Un vistazo a los indicadores que seguimos cuando buscamos propiedades con potencial de crecimiento resistente.', 'hu' => 'Pillantás azokra a mutatókra, amelyeket ellenálló növekedési potenciállal rendelkező ingatlanok keresése során követünk.'],
                'content' => ['en' => 'Transport upgrades, rental demand, renovation activity, and amenity improvements all shape local value. Learn how we prioritize neighborhoods with durable growth signals.', 'es' => 'Las mejoras de transporte, la demanda de alquiler, la actividad de renovación y las mejoras de servicios dan forma al valor local. Aprende cómo priorizamos los vecindarios con señales de crecimiento duradero.', 'hu' => 'A közlekedési fejlesztések, a bérleti igény, a felújítási tevékenység és az infrastruktúra-fejlesztések mind alakítják a helyi értéket. Tanuld meg, hogyan priorizáljuk a tartós növekedési jelekkel rendelkező kerületeket.'],
                'image' => '/images/defaults/blog-4.jpg',
                'category' => 'Market Insight',
                'author' => 'Thomas Stevens',
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($posts as $post) {
            $row = BlogPost::firstOrNew(['slug' => $post['slug']]);
            $row->slug = $post['slug'];
            $row->image = $post['image'];
            $row->category = $post['category'];
            $row->author = $post['author'];
            $row->published_at = $post['published_at'];
            $row->is_published = true;
            foreach ($post['title'] as $locale => $val) {
                $row->setTranslation('title', $locale, $val);
            }
            foreach ($post['excerpt'] as $locale => $val) {
                $row->setTranslation('excerpt', $locale, $val);
            }
            foreach ($post['content'] as $locale => $val) {
                $row->setTranslation('content', $locale, $val);
            }
            $row->save();
        }
    }
}
