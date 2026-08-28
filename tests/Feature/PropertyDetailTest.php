<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_details_show_property_and_external_ids(): void
    {
        $property = Property::create([
            'slug' => 'modern-flat-in-alicante',
            'title' => ['en' => 'Modern Flat in Alicante', 'es' => 'Piso Moderno en Alicante', 'hu' => 'Modern Lakás Alicantéban'],
            'description' => ['en' => 'Description', 'es' => 'Descripción', 'hu' => 'Leírás'],
            'address' => 'Test Street 1',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03001',
            'price' => 250000,
            'currency' => 'EUR',
            'property_type' => 'flat',
            'status' => 'for_sale',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'sqm' => 80,
            'images' => [],
            'is_featured' => false,
            'property_id_ref' => 'DOB-2001',
            'external_id' => 'EXT-9001',
        ]);
        $property = $property->fresh();

        $this->get('/properties/'.$property->slug)
            ->assertOk()
            ->assertSee('Property ID')
            ->assertDontSee('DOB-2001')
            ->assertSee('EXT-9001');
    }

    public function test_property_description_preserves_line_breaks(): void
    {
        $property = Property::create([
            'slug' => 'beachside-studio-28m2-for-rent-just-50-metres-from-the-sea',
            'title' => ['en' => 'Beachside Studio', 'es' => 'Estudio junto a la playa', 'hu' => 'Tengerparti stúdió'],
            'description' => [
                'en' => 'First line' . "\n\n" . 'Second line',
                'es' => 'Primera línea',
                'hu' => 'Első sor' . "\n\n" . 'Második sor',
            ],
            'address' => 'Beach Road 5',
            'city' => 'Torrevieja',
            'state_country' => 'Spain',
            'postal_code' => '03181',
            'price' => 900,
            'currency' => 'EUR',
            'property_type' => 'flat',
            'status' => 'for_rent',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'sqm' => 28,
            'images' => [],
            'is_featured' => false,
        ]);

        $property = $property->fresh();

        $this->get('/hu/ingatlanok/' . $property->slug)
            ->assertOk()
            ->assertSee('Első sor', false)
            ->assertSee('Első sor<br', false)
            ->assertSee('<br />', false)
            ->assertSee('Második sor', false);
    }
}
