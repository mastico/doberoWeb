<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => ['en' => 'DOBERO', 'es' => 'DOBERO', 'hu' => 'DOBERO'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'site_description', 'value' => ['en' => 'The DOBERO team is who realize your spanish home! The key to your spanish home is here with us!', 'es' => '¡El equipo DOBERO es quien realiza tu hogar español! ¡La llave de tu hogar español está aquí con nosotros!', 'hu' => 'A DOBERO csapata valósítja meg az ön spanyol otthonát! A kulcs az ön spanyol otthonához itt van nálunk!'], 'type' => 'textarea', 'is_translatable' => true],
            ['key' => 'footer_about', 'value' => ['en' => 'DOBERO combines property search, relocation support, construction guidance, and local expertise to help international buyers invest with confidence on the Costa Blanca.', 'es' => 'DOBERO combina búsqueda de propiedades, apoyo para la reubicación, orientación en construcción y experiencia local para ayudar a compradores internacionales a invertir con confianza en la Costa Blanca.', 'hu' => 'A DOBERO ingatlankeresést, költözési támogatást, építési útmutatást és helyi szakértelmet kombinál, hogy a nemzetközi vásárlók magabiztosan fektessenek be a Costa Blancán.'], 'type' => 'textarea', 'is_translatable' => true],
            ['key' => 'address', 'value' => ['en' => 'Costa Blanca, Spain'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'phone', 'value' => ['en' => '+1 (800) 990 8877'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'email', 'value' => ['en' => 'info@dobero.es'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'social_facebook', 'value' => ['en' => '#'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'social_instagram', 'value' => ['en' => '#'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'social_twitter', 'value' => ['en' => '#'], 'type' => 'text', 'is_translatable' => false],
        ];

        foreach ($settings as $setting) {
            $row = SiteSetting::firstOrNew(['key' => $setting['key']]);
            $row->type = $setting['type'];
            $row->is_translatable = $setting['is_translatable'];
            foreach ($setting['value'] as $locale => $val) {
                $row->setTranslation('value', $locale, $val);
            }
            $row->save();
        }
    }
}
