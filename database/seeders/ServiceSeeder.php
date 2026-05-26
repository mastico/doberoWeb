<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title' => ['en' => 'Property Management', 'es' => 'Gestión de Propiedades', 'hu' => 'Ingatlankezelés'], 'description' => ['en' => 'End-to-end support for owners who need local supervision, tenant coordination, and maintenance oversight.', 'es' => 'Apoyo integral para propietarios que necesitan supervisión local, coordinación de inquilinos y supervisión de mantenimiento.', 'hu' => 'Teljes körű támogatás tulajdonosok számára, akiknek helyi felügyelet, bérlői koordináció és karbantartási felügyelet szükséges.'], 'image' => '/images/defaults/service-1.jpg', 'icon' => 'home', 'category' => 'Management', 'sort_order' => 1],
            ['title' => ['en' => 'Capital Investments', 'es' => 'Inversiones de Capital', 'hu' => 'Tőkebefektetések'], 'description' => ['en' => 'Data-backed sourcing for buyers targeting long-term value, rental income, or development upside.', 'es' => 'Búsqueda respaldada por datos para compradores que apuntan a valor a largo plazo, ingresos por alquiler o potencial de desarrollo.', 'hu' => 'Adatvezérelt forrás hosszú távú értékre, bérleti bevételre vagy fejlesztési potenciálra törekvő vevők számára.'], 'image' => '/images/defaults/service-2.jpg', 'icon' => 'chart-bar', 'category' => 'Investment', 'sort_order' => 2],
            ['title' => ['en' => 'Finance Real Estate', 'es' => 'Financiación Inmobiliaria', 'hu' => 'Ingatlanfinanszírozás'], 'description' => ['en' => 'Mortgage guidance, affordability planning, and finance introductions for local and foreign buyers.', 'es' => 'Orientación hipotecaria, planificación de asequibilidad e introducción financiera para compradores locales y extranjeros.', 'hu' => 'Jelzálog-útmutatás, megfizethetőség-tervezés és pénzügyi bevezető helyi és külföldi vevők számára.'], 'image' => '/images/defaults/service-3.jpg', 'icon' => 'banknotes', 'category' => 'Finance', 'sort_order' => 3],
            ['title' => ['en' => 'Recover Asset Value', 'es' => 'Recuperar Valor de Activos', 'hu' => 'Eszközérték Visszaállítása'], 'description' => ['en' => 'Refurbishment planning and technical assessments to unlock value in dated or underperforming properties.', 'es' => 'Planificación de reformas y evaluaciones técnicas para desbloquear valor en propiedades anticuadas o de bajo rendimiento.', 'hu' => 'Felújítástervezés és műszaki értékelések az elavult vagy alulteljesítő ingatlanokban lévő érték felszabadítására.'], 'image' => '/images/defaults/service-4.jpg', 'icon' => 'wrench-screwdriver', 'category' => 'Construction', 'sort_order' => 4],
            ['title' => ['en' => 'Financial Reporting', 'es' => 'Informes Financieros', 'hu' => 'Pénzügyi Jelentések'], 'description' => ['en' => 'Clear reporting for investors who want visibility on costs, works, and performance indicators.', 'es' => 'Informes claros para inversores que quieren visibilidad sobre costes, obras e indicadores de rendimiento.', 'hu' => 'Egyértelmű jelentések befektetők számára, akik láthatóságot szeretnének a költségekre, munkálatokra és teljesítménymutatókra.'], 'image' => '/images/defaults/service-5.jpg', 'icon' => 'document-chart-bar', 'category' => 'Advisory', 'sort_order' => 5],
            ['title' => ['en' => 'Business Development', 'es' => 'Desarrollo de Negocios', 'hu' => 'Üzletfejlesztés'], 'description' => ['en' => 'Commercial strategy support for developers, landlords, and partners expanding their portfolio footprint.', 'es' => 'Apoyo en estrategia comercial para desarrolladores, propietarios y socios que expanden su cartera.', 'hu' => 'Kereskedelmi stratégiai támogatás fejlesztők, bérbeadók és partnerek számára, akik bővítik portfóliójukat.'], 'image' => '/images/defaults/service-6.jpg', 'icon' => 'briefcase', 'category' => 'Growth', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            $row = Service::firstOrNew(['category' => $service['category'], 'sort_order' => $service['sort_order']]);
            $row->image = $service['image'];
            $row->icon = $service['icon'];
            $row->category = $service['category'];
            $row->sort_order = $service['sort_order'];
            $row->is_active = true;
            foreach ($service['title'] as $locale => $val) {
                $row->setTranslation('title', $locale, $val);
            }
            foreach ($service['description'] as $locale => $val) {
                $row->setTranslation('description', $locale, $val);
            }
            $row->save();
        }
    }
}
