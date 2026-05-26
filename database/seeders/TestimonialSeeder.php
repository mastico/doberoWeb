<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'author_name' => 'Roy Bennett',
                'content' => ['en' => "Really good service. We can't understand how we've been living without DOBERO. They handled our NIE, bank account, and found us the perfect flat in Alicante.", 'es' => 'Realmente buen servicio. No podemos entender cómo hemos vivido sin DOBERO. Gestionaron nuestro NIE, cuenta bancaria y nos encontraron el piso perfecto en Alicante.', 'hu' => 'Igazán jó szolgáltatás. Nem értjük, hogyan éltünk DOBERO nélkül. Intézték a NIE-nkat, a bankszámlánkat, és megtalálták nekünk a tökéletes lakást Alicantéban.'],
                'author_role' => ['en' => 'Marketing Manager', 'es' => 'Directora de Marketing', 'hu' => 'Marketing Menedzser'],
                'author_company' => 'United Kingdom',
                'author_photo' => '/images/defaults/testimonial-1.jpg',
                'sort_order' => 1,
            ],
            [
                'author_name' => 'Kenneth Sandoval',
                'content' => ['en' => 'Great work on finding our investment property. I like DOBERO more and more each day because it makes my life easier and a lot more profitable.', 'es' => 'Excelente trabajo para encontrar nuestra propiedad de inversión. Me gusta DOBERO cada día más porque hace mi vida más fácil y mucho más rentable.', 'hu' => 'Kiváló munka a befektetési ingatlanunk megtalálásában. Napról napra jobban szeretem a DOBERO-t, mert könnyebbé és sokkal jövedelmezőbbé teszi az életemet.'],
                'author_role' => ['en' => 'Investor', 'es' => 'Inversor', 'hu' => 'Befektető'],
                'author_company' => 'United States',
                'author_photo' => '/images/defaults/testimonial-2.jpg',
                'sort_order' => 2,
            ],
            [
                'author_name' => 'Kathleen Peterson',
                'content' => ['en' => 'DOBERO is the best real estate partner I have ever worked with. I strongly recommend them to everyone interested in buying property in Spain successfully.', 'es' => 'DOBERO es el mejor socio inmobiliario con el que he trabajado. Los recomiendo encarecidamente a todos los interesados en comprar una propiedad en España con éxito.', 'hu' => 'A DOBERO a legjobb ingatlan partner, akivel valaha dolgoztam. Erősen ajánlom mindenki számára, aki sikeresen szeretne ingatlant vásárolni Spanyolországban.'],
                'author_role' => ['en' => 'Sales Manager', 'es' => 'Directora de Ventas', 'hu' => 'Értékesítési Menedzser'],
                'author_company' => 'Germany',
                'author_photo' => '/images/defaults/testimonial-3.jpg',
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            $row = Testimonial::firstOrNew(['author_name' => $t['author_name']]);
            $row->author_company = $t['author_company'];
            $row->author_photo = $t['author_photo'];
            $row->sort_order = $t['sort_order'];
            $row->is_active = true;
            foreach ($t['content'] as $locale => $val) {
                $row->setTranslation('content', $locale, $val);
            }
            foreach ($t['author_role'] as $locale => $val) {
                $row->setTranslation('author_role', $locale, $val);
            }
            $row->save();
        }
    }
}
