<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'János Németh',
                'photo' => '/images/defaults/team-janos.jpg',
                'role' => ['en' => 'CEO', 'es' => 'CEO', 'hu' => 'Vezérigazgató'],
                'bio' => ['en' => 'János leads DOBERO with decades of cross-border property consulting and investment strategy experience on the Costa Blanca.', 'es' => 'János lidera DOBERO con décadas de experiencia en consultoría de propiedades transfronterizas y estrategia de inversión en la Costa Blanca.', 'hu' => 'János évtizedes határokon átnyúló ingatlan-tanácsadási és befektetési stratégiai tapasztalattal vezeti a DOBERO-t a Costa Blancán.'],
                'sort_order' => 1,
            ],
            [
                'name' => 'Nydia Olaizola Sentí',
                'photo' => '/images/defaults/team-nydia.jpg',
                'role' => ['en' => 'Lawyer', 'es' => 'Abogada', 'hu' => 'Ügyvéd'],
                'bio' => ['en' => 'Nydia handles all legal aspects of property acquisition and conveyancing, ensuring a smooth and legally sound transaction for every client.', 'es' => 'Nydia se encarga de todos los aspectos legales de la adquisición de propiedades, garantizando una transacción segura para cada cliente.', 'hu' => 'Nydia kezeli az ingatlanvásárlás összes jogi aspektusát, biztosítva a zökkenőmentes és jogilag megalapozott tranzakciókat.'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Jovi Tortosa',
                'photo' => '/images/defaults/team-jovi.jpg',
                'role' => ['en' => 'Architect', 'es' => 'Arquitecto', 'hu' => 'Építész'],
                'bio' => ['en' => 'Jovi designs and oversees construction projects, bringing creative vision and technical expertise to every build on the Costa Blanca.', 'es' => 'Jovi diseña y supervisa proyectos de construcción, aportando visión creativa y experiencia técnica a cada obra en la Costa Blanca.', 'hu' => 'Jovi tervez és felügyel kivitelezési projekteket, kreatív vízióval és műszaki szakértelemmel.'],
                'sort_order' => 3,
            ],
            [
                'name' => 'Daria Artemyeva',
                'photo' => '/images/defaults/team-daria.jpg',
                'role' => ['en' => 'Interior Architect', 'es' => 'Arquitecta de Interiores', 'hu' => 'Belsőépítész'],
                'bio' => ['en' => 'Daria transforms spaces into elegant, functional homes, balancing aesthetics and practicality for international clients.', 'es' => 'Daria transforma espacios en hogares elegantes y funcionales, equilibrando estética y practicidad para clientes internacionales.', 'hu' => 'Daria elegáns, funkcionális otthonokká alakítja a tereket, esztétikát és praktikusságot ötvözve.'],
                'sort_order' => 4,
            ],
            [
                'name' => 'Sara Travieso Garcia',
                'photo' => '/images/defaults/team-sara.jpg',
                'role' => ['en' => 'Real Estate Agent', 'es' => 'Agente Inmobiliaria', 'hu' => 'Ingatlanügynök'],
                'bio' => ['en' => 'Sara guides buyers through property searches, viewings, and negotiations, matching clients to their ideal home on the Costa Blanca.', 'es' => 'Sara acompaña a los compradores en la búsqueda de propiedades, visitas y negociaciones, encontrando el hogar ideal en la Costa Blanca.', 'hu' => 'Sara segíti a vevőket az ingatlankeresésben, megtekintésekben és tárgyalásokban, megtalálva az ideális otthont.'],
                'sort_order' => 5,
            ],
            [
                'name' => 'Michael Ramirez Da Silva',
                'photo' => '/images/defaults/team-michael.jpg',
                'role' => ['en' => 'Solar Systems Specialist', 'es' => 'Especialista en Energía Solar', 'hu' => 'Napenergia-rendszer Szakértő'],
                'bio' => ['en' => 'Michael designs and installs solar energy systems, helping property owners reduce costs and embrace sustainable living.', 'es' => 'Michael diseña e instala sistemas de energía solar, ayudando a los propietarios a reducir costes y apostar por un estilo de vida sostenible.', 'hu' => 'Michael napenergia-rendszereket tervez és telepít, segítve az ingatlan-tulajdonosokat a fenntartható életmód megvalósításában.'],
                'sort_order' => 6,
            ],
            [
                'name' => 'Jonathan',
                'photo' => '/images/defaults/team-jonathan.jpg',
                'role' => ['en' => 'Vertical Works Specialist', 'es' => 'Especialista en Trabajos Verticales', 'hu' => 'Magassági Munkák Szakértője'],
                'bio' => ['en' => 'Jonathan specialises in vertical access and facade works, maintaining and renovating building exteriors with safety and precision.', 'es' => 'Jonathan se especializa en trabajos de acceso vertical y fachadas, manteniendo y renovando exteriores con seguridad y precisión.', 'hu' => 'Jonathan a függőleges munkák és homlokzati munkák specialistája, biztonságosan és pontosan végzi a karbantartást és felújítást.'],
                'sort_order' => 7,
            ],
            [
                'name' => 'Héctor Soler Alonso',
                'photo' => '/images/defaults/team-hector.jpg',
                'role' => ['en' => 'Electrical & SMART Systems', 'es' => 'Instalaciones Eléctricas y Sistemas SMART', 'hu' => 'Elektromos és Okos Rendszerek'],
                'bio' => ['en' => 'Héctor oversees all electrical installations and smart-home integrations, ensuring modern, energy-efficient solutions for every property.', 'es' => 'Héctor supervisa todas las instalaciones eléctricas e integraciones de hogar inteligente, asegurando soluciones modernas y eficientes.', 'hu' => 'Héctor felügyeli az összes elektromos szerelést és okosotthon-integrációt, modern és energiahatékony megoldásokat biztosítva.'],
                'sort_order' => 8,
            ],
            [
                'name' => 'Ricardo Alejo',
                'photo' => '/images/defaults/team-ricardo.jpg',
                'role' => ['en' => 'Drywall & Painting', 'es' => 'Pladur y Pintura', 'hu' => 'Szárazépítés és Festés'],
                'bio' => ['en' => 'Ricardo delivers high-quality drywall and painting finishes, transforming interiors to a professional standard on every project.', 'es' => 'Ricardo realiza trabajos de alta calidad en pladur y pintura, transformando interiores con acabados profesionales en cada proyecto.', 'hu' => 'Ricardo kiváló minőségű szárazépítési és festési munkákat végez, professzionális belső tér-kialakítással.'],
                'sort_order' => 9,
            ],
            [
                'name' => 'Julián Vico Rentero',
                'photo' => '/images/defaults/team-julian.jpg',
                'role' => ['en' => 'Court Expert', 'es' => 'Perito Judicial', 'hu' => 'Igazságügyi Szakértő'],
                'bio' => ['en' => 'Julián provides expert appraisals and technical reports for legal proceedings, protecting clients in complex property disputes.', 'es' => 'Julián proporciona peritajes y dictámenes técnicos para procedimientos judiciales, protegiendo a los clientes en disputas de propiedad.', 'hu' => 'Julián szakvéleményeket és műszaki jelentéseket készít jogi eljárásokhoz, megvédve az ügyfeleket az ingatlanvitákban.'],
                'sort_order' => 10,
            ],
            [
                'name' => 'Pedro',
                'photo' => '/images/defaults/team-pedro.jpg',
                'role' => ['en' => 'Alarm Systems Specialist', 'es' => 'Especialista en Sistemas de Alarma', 'hu' => 'Riasztórendszer Szakértő'],
                'bio' => ['en' => 'Pedro installs and maintains alarm and security systems, giving property owners peace of mind with reliable protection.', 'es' => 'Pedro instala y mantiene sistemas de alarma y seguridad, ofreciendo tranquilidad a los propietarios con una protección fiable.', 'hu' => 'Pedro riasztó- és biztonsági rendszereket telepít és tart karban, megbízható védelmet biztosítva az ingatlan-tulajdonosoknak.'],
                'sort_order' => 11,
            ],
            [
                'name' => 'Antonio Ortigosa',
                'photo' => '/images/defaults/team-antonio.jpg',
                'role' => ['en' => 'Aluminum Carpentry', 'es' => 'Carpintería de Aluminio', 'hu' => 'Alumínium Asztalos'],
                'bio' => ['en' => 'Antonio fabricates and installs aluminium windows, doors, and facades, combining durability and contemporary design.', 'es' => 'Antonio fabrica e instala ventanas, puertas y fachadas de aluminio, combinando durabilidad y diseño contemporáneo.', 'hu' => 'Antonio alumínium nyílászárókat, ajtókat és homlokzatokat gyárt és szerel, tartósságot és modern designt ötvözve.'],
                'sort_order' => 12,
            ],
        ];

        foreach ($members as $member) {
            $row = TeamMember::firstOrNew(['name' => $member['name']]);
            $row->photo = $member['photo'];
            $row->sort_order = $member['sort_order'];
            $row->is_active = true;
            foreach ($member['role'] as $locale => $val) {
                $row->setTranslation('role', $locale, $val);
            }
            foreach ($member['bio'] as $locale => $val) {
                $row->setTranslation('bio', $locale, $val);
            }
            $row->save();
        }
    }
}
