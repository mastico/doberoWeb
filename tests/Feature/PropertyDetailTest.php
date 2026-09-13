<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\PropertyDetail;
use App\Models\ContactInquiry;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
                'en' => 'First line'."\n\n".'Second line',
                'es' => 'Primera línea',
                'hu' => 'Első sor'."\n\n".'Második sor',
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

        $this->get('/hu/ingatlanok/'.$property->slug)
            ->assertOk()
            ->assertSee('Első sor', false)
            ->assertSee('Első sor<br', false)
            ->assertSee('<br />', false)
            ->assertSee('Második sor', false);
    }

    public function test_property_inquiry_requires_privacy_consent(): void
    {
        $property = Property::create([
            'title' => ['en' => 'Consent Test Property'],
            'description' => ['en' => 'Description'],
            'address' => 'Test Street 2',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03002',
            'price' => 180000,
            'currency' => 'EUR',
            'property_type' => 'flat',
            'status' => 'for_sale',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'sqm' => 70,
            'images' => [],
        ])->fresh();

        Livewire::test(PropertyDetail::class, ['slug' => $property->slug])
            ->set('inquiry.first_name', 'Ada')
            ->set('inquiry.last_name', 'Lovelace')
            ->set('inquiry.email', 'ada@example.test')
            ->set('inquiry.phone', '+34 600 000 000')
            ->set('inquiry.message', 'Please send more details.')
            ->call('submitInquiry')
            ->assertHasErrors(['inquiry.privacy_consent' => 'accepted']);

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_property_inquiry_persists_without_a_privacy_consent_marker_after_acceptance(): void
    {
        $property = Property::create([
            'title' => ['en' => 'Accepted Inquiry Property'],
            'description' => ['en' => 'Description'],
            'address' => 'Test Street 3',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03003',
            'price' => 220000,
            'currency' => 'EUR',
            'property_type' => 'flat',
            'status' => 'for_sale',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'sqm' => 75,
            'images' => [],
        ])->fresh();

        $component = Livewire::test(PropertyDetail::class, ['slug' => $property->slug])
            ->set('inquiry.first_name', 'Ada')
            ->set('inquiry.last_name', 'Lovelace')
            ->set('inquiry.email', 'ada@example.test')
            ->set('inquiry.phone', '+34 600 000 000')
            ->set('inquiry.message', 'Please send more details.')
            ->set('inquiry.privacy_consent', true)
            ->call('submitInquiry')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('contact_inquiries', [
            'property_id' => $property->id,
            'inquiry_type' => 'property_inquiry',
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.test',
            'phone' => '+34 600 000 000',
            'message' => 'Please send more details.',
        ]);

        $inquiry = ContactInquiry::query()->sole();

        $this->assertArrayNotHasKey('privacy_consent', $inquiry->getAttributes());
        $this->assertFalse($component->get('inquiry.privacy_consent'));
    }

    public function test_property_inquiry_privacy_link_is_localized(): void
    {
        $property = Property::create([
            'title' => ['en' => 'Localized Inquiry Property'],
            'description' => ['en' => 'Description'],
            'address' => 'Test Street 4',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03004',
            'price' => 240000,
            'currency' => 'EUR',
            'property_type' => 'flat',
            'status' => 'for_sale',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'sqm' => 80,
            'images' => [],
        ])->fresh();

        $localizedExpectations = [
            '/properties/'.$property->slug => [
                'url' => url('/privacy-policy'),
                'label' => 'I have read and accept the Privacy Policy',
            ],
            '/es/propiedades/'.$property->slug => [
                'url' => url('/es/politica-privacidad'),
                'label' => 'He leído y acepto la Política de Privacidad',
            ],
            '/hu/ingatlanok/'.$property->slug => [
                'url' => url('/hu/adatvedelmi-tajekoztato'),
                'label' => 'Elolvastam és elfogadom az Adatvédelmi tájékoztatót',
            ],
        ];

        foreach ($localizedExpectations as $path => $expectation) {
            $this->get($path)
                ->assertOk()
                ->assertSee('wire:model="inquiry.privacy_consent"', false)
                ->assertSee('href="'.$expectation['url'].'"', false)
                ->assertSee($expectation['label']);
        }
    }
}
