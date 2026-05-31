<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'slug' => 'sea-view-villa-in-marbella',
                'title' => ['en' => 'Sea View Villa in Marbella', 'es' => 'Villa con Vistas al Mar en Marbella', 'hu' => 'Tengerre Néző Villa Marbellában'],
                'description' => ['en' => 'A bright, contemporary villa with panoramic terraces, landscaped gardens, and indoor-outdoor living designed for year-round sunshine.', 'es' => 'Una villa contemporánea luminosa con terrazas panorámicas, jardines paisajísticos y vida interior-exterior diseñada para el sol durante todo el año.', 'hu' => 'Egy világos, kortárs villa panorámás teraszokkal, gondozott kertekkel és beltéri-kültéri életterekkel, amelyeket az egész éves napsütésre terveztek.'],
                'address' => 'Avenida del Mar 18',
                'city' => 'Marbella',
                'state_country' => 'Andalusia, Spain',
                'postal_code' => '29602',
                'price' => 1450000,
                'property_type' => 'house',
                'status' => 'for_sale',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'sqm' => 340,
                'images' => ['/images/defaults/property-1a.jpg', '/images/defaults/property-1b.jpg', '/images/defaults/property-1c.jpg'],
                'is_featured' => true,
                'property_id_ref' => 'DOB-1001',
            ],
            [
                'slug' => 'modern-apartment-in-valencia-center',
                'title' => ['en' => 'Modern Apartment in Valencia Center', 'es' => 'Apartamento Moderno en el Centro de Valencia', 'hu' => 'Modern Lakás Valencia Belvárosában'],
                'description' => ['en' => 'A fully renovated city apartment close to restaurants, transport, and the historic center, ideal for urban living or executive rental demand.', 'es' => 'Un apartamento urbano completamente reformado cerca de restaurantes, transporte y el centro histórico, ideal para vida urbana o demanda de alquiler ejecutivo.', 'hu' => 'Teljesen felújított városi lakás éttermek, tömegközlekedés és a történelmi belváros közelében, ideális városi életmódhoz vagy üzleti bérleti igényhez.'],
                'address' => 'Carrer de Colón 74',
                'city' => 'Valencia',
                'state_country' => 'Valencian Community, Spain',
                'postal_code' => '46004',
                'price' => 385000,
                'property_type' => 'flat',
                'status' => 'for_sale',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'sqm' => 118,
                'images' => ['/images/defaults/property-2a.jpg', '/images/defaults/property-2b.jpg', '/images/defaults/property-2c.jpg'],
                'is_featured' => true,
                'property_id_ref' => 'DOB-1002',
            ],
            [
                'slug' => 'beachfront-flat-in-alicante',
                'title' => ['en' => 'Beachfront Flat in Alicante', 'es' => 'Piso en Primera Línea de Playa en Alicante', 'hu' => 'Strandfront Lakás Alicantéban'],
                'description' => ['en' => 'Wake up to Mediterranean views in this turnkey flat with balcony, open living space, and direct access to the promenade.', 'es' => 'Despiértate con vistas al Mediterráneo en este piso listo para entrar con balcón, espacio de vida abierto y acceso directo al paseo marítimo.', 'hu' => 'Ébredj mediterrán kilátásra ebben a kulcsrakész lakásban erkéllyel, nyitott nappalival és közvetlen sétányi hozzáféréssel.'],
                'address' => 'Passeig Marítim 9',
                'city' => 'Alicante',
                'state_country' => 'Valencian Community, Spain',
                'postal_code' => '03002',
                'price' => 549000,
                'property_type' => 'flat',
                'status' => 'for_sale',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'sqm' => 96,
                'images' => ['/images/defaults/property-3a.jpg', '/images/defaults/property-3b.jpg', '/images/defaults/property-3c.jpg'],
                'is_featured' => true,
                'property_id_ref' => 'DOB-1003',
            ],
            [
                'slug' => 'renovation-opportunity-townhouse-in-malaga',
                'title' => ['en' => 'Renovation Opportunity Townhouse in Málaga', 'es' => 'Oportunidad de Reforma en Casa Adosada en Málaga', 'hu' => 'Felújítási Lehetőség Sorházban Málagában'],
                'description' => ['en' => 'A character-filled property with strong upside potential, generous floor area, and a central location for a full value-add project.', 'es' => 'Una propiedad llena de carácter con fuerte potencial alcista, generosa superficie habitable y una ubicación céntrica para un proyecto completo de añadir valor.', 'hu' => 'Jellemzőkkel teli ingatlan erős felértékelési potenciállal, bőséges alapterülettel és központi elhelyezkedéssel egy teljes értéknövelő projekthez.'],
                'address' => 'Calle Granada 41',
                'city' => 'Málaga',
                'state_country' => 'Andalusia, Spain',
                'postal_code' => '29015',
                'price' => 298000,
                'property_type' => 'house',
                'status' => 'for_sale',
                'bedrooms' => 4,
                'bathrooms' => 2,
                'sqm' => 180,
                'images' => ['/images/defaults/property-4a.jpg', '/images/defaults/property-4b.jpg', '/images/defaults/property-4c.jpg'],
                'is_featured' => false,
                'property_id_ref' => 'DOB-1004',
            ],
            [
                'slug' => 'commercial-showroom-in-barcelona',
                'title' => ['en' => 'Commercial Showroom in Barcelona', 'es' => 'Sala de Exposiciones Comercial en Barcelona', 'hu' => 'Kereskedelmi Bemutatóterem Barcelonában'],
                'description' => ['en' => 'High-visibility commercial space with modern frontage, flexible interior layout, and proximity to major retail footfall.', 'es' => 'Espacio comercial de alta visibilidad con fachada moderna, distribución interior flexible y proximidad a grandes zonas comerciales.', 'hu' => 'Nagy láthatóságú kereskedelmi tér modern homlokzattal, rugalmas belső elrendezéssel és jelentős kiskereskedelmi forgalom közelségével.'],
                'address' => 'Rambla de Catalunya 61',
                'city' => 'Barcelona',
                'state_country' => 'Catalonia, Spain',
                'postal_code' => '08007',
                'price' => 7200,
                'property_type' => 'flat',
                'status' => 'for_rent',
                'bedrooms' => 0,
                'bathrooms' => 1,
                'sqm' => 210,
                'images' => ['/images/defaults/property-5a.jpg', '/images/defaults/property-5b.jpg', '/images/defaults/property-5c.jpg'],
                'is_featured' => false,
                'property_id_ref' => 'DOB-1005',
            ],
            [
                'slug' => 'build-ready-plot-in-costa-blanca',
                'title' => ['en' => 'Build-Ready Plot in Costa Blanca', 'es' => 'Parcela Lista para Construir en la Costa Blanca', 'hu' => 'Építésre Kész Telek a Costa Blancán'],
                'description' => ['en' => 'An elevated land parcel with open views, utility access nearby, and the potential for a custom-designed villa.', 'es' => 'Una parcela elevada con vistas abiertas, acceso cercano a servicios y potencial para una villa de diseño personalizado.', 'hu' => 'Emelt fekvésű földterület nyílt kilátással, közeli közmű-hozzáféréssel és egyedi tervezésű villa építési lehetőségével.'],
                'address' => 'Parcela 22, Monte Sol',
                'city' => 'Jávea',
                'state_country' => 'Valencian Community, Spain',
                'postal_code' => '03730',
                'price' => 240000,
                'property_type' => 'house',
                'status' => 'for_sale',
                'bedrooms' => 0,
                'bathrooms' => 0,
                'sqm' => 950,
                'images' => ['/images/defaults/property-6a.jpg', '/images/defaults/property-6b.jpg', '/images/defaults/property-6c.jpg'],
                'is_featured' => false,
                'property_id_ref' => 'DOB-1006',
            ],
        ];

        foreach ($properties as $property) {
            $row = Property::firstOrNew(['slug' => $property['slug']]);
            $row->slug = $property['slug'];
            $row->address = $property['address'];
            $row->city = $property['city'];
            $row->state_country = $property['state_country'];
            $row->postal_code = $property['postal_code'];
            $row->price = $property['price'];
            $row->property_type = $property['property_type'];
            $row->status = $property['status'];
            $row->bedrooms = $property['bedrooms'];
            $row->bathrooms = $property['bathrooms'];
            $row->sqm = $property['sqm'];
            $row->images = $property['images'];
            $row->is_featured = $property['is_featured'];
            $row->property_id_ref = $property['property_id_ref'];
            foreach ($property['title'] as $locale => $val) {
                $row->setTranslation('title', $locale, $val);
            }
            foreach ($property['description'] as $locale => $val) {
                $row->setTranslation('description', $locale, $val);
            }
            $row->save();
        }
    }
}
