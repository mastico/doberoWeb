<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Admin\PropertyForm;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_form_requires_address_before_saving(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        Livewire::test(PropertyForm::class)
            ->set('form.title.en', 'Torrevieja Studio')
            ->set('form.description.en', 'Bright studio close to the sea.')
            ->set('form.address', '')
            ->set('form.city', 'Torrevieja')
            ->set('form.state_country', 'Alicante')
            ->set('form.postal_code', '03181')
            ->set('form.price', '900')
            ->set('form.currency', 'EUR')
            ->set('form.property_type', 'house')
            ->set('form.status', 'for_rent')
            ->set('form.bedrooms', 1)
            ->set('form.bathrooms', 1)
            ->set('form.sqm', '28')
            ->call('save')
            ->assertHasErrors(['form.address' => 'required']);

        $this->assertDatabaseCount('properties', 0);
    }

    public function test_property_form_saves_property_and_redirects_when_valid(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());
        Storage::fake('public');

        $mainImage = UploadedFile::fake()->image('main-photo.jpg');
        $galleryImageOne = UploadedFile::fake()->image('gallery-one.jpg');
        $galleryImageTwo = UploadedFile::fake()->image('gallery-two.jpg');

        Livewire::test(PropertyForm::class)
            ->set('form.title.en', 'Beachside House')
            ->set('form.title.es', 'Casa junto a la playa')
            ->set('form.description.en', 'Beautiful rental home one minute from the beach.')
            ->set('form.description.es', 'Hermosa vivienda en alquiler a un minuto de la playa.')
            ->set('form.address', 'Calle del Mar 12')
            ->set('form.city', 'Torrevieja')
            ->set('form.state_country', 'Alicante')
            ->set('form.postal_code', '03181')
            ->set('form.price', '900')
            ->set('form.currency', 'EUR')
            ->set('form.property_type', 'house')
            ->set('form.status', 'for_rent')
            ->set('form.bedrooms', 1)
            ->set('form.bathrooms', 1)
            ->set('form.sqm', '28')
            ->set('form.is_featured', true)
            ->set('form.meta_title.en', 'Beachside House for Rent')
            ->set('form.meta_description.en', 'Coastal rental in Torrevieja.')
            ->set('mainImageUpload', $mainImage)
            ->set('galleryImageUploads', [$galleryImageOne, $galleryImageTwo])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.properties.index'));

        $this->assertDatabaseCount('properties', 1);

        $property = Property::query()->firstOrFail();

        $this->assertSame('Calle del Mar 12', $property->address);
        $this->assertSame('Torrevieja', $property->city);
        $this->assertSame('house', $property->property_type);
        $this->assertSame('for_rent', $property->status);
        $this->assertTrue($property->is_featured);
        $this->assertSame('Beachside House', $property->getTranslation('title', 'en'));
        $this->assertSame('Casa junto a la playa', $property->getTranslation('title', 'es'));
        $this->assertSame('beachside-house-'.$property->id, $property->slug);
        $this->assertCount(3, $property->images);
        $this->assertStringStartsWith('properties/', $property->images[0]);
        $this->assertStringStartsWith('properties/', $property->images[1]);
        $this->assertStringStartsWith('properties/', $property->images[2]);

        foreach ($property->images as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }
}

