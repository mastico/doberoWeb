<?php

namespace Tests\Feature;

use App\Livewire\PropertiesListing;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyImportTest extends TestCase
{
    use RefreshDatabase;

    private function makeProperty(array $overrides = []): Property
    {
        return Property::create(array_merge([
            'title' => ['en' => 'Test Property'],
            'description' => ['en' => 'Test description'],
            'address' => '123 Test St',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03001',
            'price' => 200000,
            'property_type' => 'house',
            'status' => 'for_sale',
        ], $overrides));
    }

    public function test_migration_adds_import_columns(): void
    {
        $property = $this->makeProperty([
            'title' => ['en' => 'Sea View Villa'],
            'description' => ['en' => 'Nice villa'],
            'source' => 'solvia',
            'external_id' => 'property-12345',
            'province' => 'Alicante',
            'living_area' => 120.50,
            'original_price' => 350000.00,
            'latitude' => 38.3451800,
            'longitude' => -0.4814600,
            'extra_data' => ['custom_field' => 'value'],
            'source_synced_at' => now(),
        ]);

        $this->assertNotNull($property->id);
        $this->assertSame('solvia', $property->source);
        $this->assertSame('property-12345', $property->external_id);
        $this->assertSame('Alicante', $property->province);
        $this->assertSame('120.50', $property->living_area);
        $this->assertSame('350000.00', $property->original_price);
        $this->assertSame('38.3451800', $property->latitude);
        $this->assertSame('-0.4814600', $property->longitude);
        $this->assertSame(['custom_field' => 'value'], $property->extra_data);
        $this->assertNotNull($property->source_synced_at);
    }

    public function test_update_or_create_is_idempotent_on_source_and_external_id(): void
    {
        $defaults = [
            'address' => '1 Test St',
            'city' => 'Alicante',
            'state_country' => 'Spain',
            'postal_code' => '03001',
            'property_type' => 'house',
        ];

        $first = Property::updateOrCreate(
            ['source' => 'solvia', 'external_id' => 'property-1'],
            array_merge($defaults, [
                'title' => ['en' => 'Original Title'],
                'description' => ['en' => 'Desc'],
                'status' => 'for_sale',
                'price' => 200000,
            ])
        );

        $second = Property::updateOrCreate(
            ['source' => 'solvia', 'external_id' => 'property-1'],
            array_merge($defaults, [
                'title' => ['en' => 'Updated Title'],
                'description' => ['en' => 'Desc'],
                'status' => 'for_sale',
                'price' => 220000,
            ])
        );

        $this->assertSame($first->id, $second->id);
        $this->assertSame(1, Property::count());
        $this->assertSame('Updated Title', Property::first()->getTranslation('title', 'en'));
    }

    public function test_sold_properties_appear_last_on_listing_page(): void
    {
        $this->makeProperty(['title' => ['en' => 'Sold House'], 'status' => 'sold']);
        $this->makeProperty(['title' => ['en' => 'Active Flat'], 'status' => 'for_sale']);
        $this->makeProperty(['title' => ['en' => 'Another Active'], 'status' => 'for_rent']);

        Livewire::test(PropertiesListing::class)
            ->assertSeeInOrder(['Active Flat', 'Another Active', 'Sold House']);
    }

    public function test_scope_sold_returns_only_sold_properties(): void
    {
        $this->makeProperty(['title' => ['en' => 'Sold One'], 'status' => 'sold']);
        $this->makeProperty(['title' => ['en' => 'Active One'], 'status' => 'for_sale']);

        $this->assertSame(1, Property::sold()->count());
        $this->assertSame('Sold One', Property::sold()->first()->getTranslation('title', 'en'));
    }
}
