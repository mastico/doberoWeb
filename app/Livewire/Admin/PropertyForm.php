<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\Property;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PropertyForm extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public ?Property $property = null;

    public array $form = [];

    public array $existingImages = [];

    public array $imageUploads = [];

    public function mount(?Property $property = null): void
    {
        $this->property = $property?->exists ? $property : null;
        $this->form = [
            'slug' => $this->property?->slug ?? '',
            'title' => $this->property ? $this->fillTranslations($this->property->getTranslations('title')) : $this->blankTranslations(),
            'description' => $this->property ? $this->fillTranslations($this->property->getTranslations('description')) : $this->blankTranslations(),
            'address' => $this->property?->address ?? '',
            'city' => $this->property?->city ?? '',
            'state_country' => $this->property?->state_country ?? '',
            'postal_code' => $this->property?->postal_code ?? '',
            'price' => $this->property?->price ?? '',
            'currency' => $this->property?->currency ?? 'EUR',
            'property_type' => $this->property?->property_type ?? 'house',
            'status' => $this->property?->status ?? 'for_sale',
            'bedrooms' => $this->property?->bedrooms ?? 0,
            'bathrooms' => $this->property?->bathrooms ?? 0,
            'sqm' => $this->property?->sqm ?? '',
            'is_featured' => $this->property?->is_featured ?? false,
            'property_id_ref' => $this->property?->property_id_ref ?? '',
            'meta_title' => $this->property ? $this->fillTranslations($this->property->getTranslations('meta_title')) : $this->blankTranslations(),
            'meta_description' => $this->property ? $this->fillTranslations($this->property->getTranslations('meta_description')) : $this->blankTranslations(),
        ];
        $this->existingImages = $this->property?->images ?? [];
    }

    public function removeImage(int $index): void
    {
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
    }

    public function save()
    {
        $rules = [
            'form.slug' => ['nullable', 'string', 'max:255'],
            'form.address' => ['required', 'string', 'max:255'],
            'form.city' => ['required', 'string', 'max:255'],
            'form.state_country' => ['required', 'string', 'max:255'],
            'form.postal_code' => ['required', 'string', 'max:255'],
            'form.price' => ['required', 'numeric'],
            'form.currency' => ['required', 'string', 'max:10'],
            'form.property_type' => ['required', 'in:flat,studio,house,duplex,penthouse,bungalow,other'],
            'form.status' => ['required', 'in:for_sale,for_rent,sold,rented,new'],
            'form.bedrooms' => ['required', 'integer', 'min:0'],
            'form.bathrooms' => ['required', 'integer', 'min:0'],
            'form.sqm' => ['required', 'numeric', 'min:0'],
            'form.is_featured' => ['boolean'],
            'form.property_id_ref' => ['nullable', 'string', 'max:255'],
            'imageUploads.*' => ['nullable', 'image', 'max:2048'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.title.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string', 'max:255'];
            $rules["form.description.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string'];
            $rules["form.meta_title.{$locale}"] = ['nullable', 'string', 'max:255'];
            $rules["form.meta_description.{$locale}"] = ['nullable', 'string'];
        }

        $validated = $this->validate($rules);

        $images = $this->existingImages;
        foreach ($this->imageUploads as $upload) {
            $path = $upload->store('properties', 'public');
            $fullPath = storage_path('app/public/'.$path);
            if (file_exists($fullPath)) {
                try {
                    OptimizerChainFactory::create()->optimize($fullPath);
                } catch (\Throwable) {
                    // Optimization failed (missing binaries); continue without it
                }
            }
            $images[] = $path;
        }

        $payload = Arr::except($validated['form'], ['title', 'description']);
        $englishTitle = $this->form['title'][default_locale()] ?? '';
        $payload['slug'] = filled($payload['slug']) ? Str::slug($payload['slug']) : Str::slug($englishTitle);
        $payload['images'] = $images;

        $property = Property::updateOrCreate(['id' => $this->property?->id], $payload);
        $property->setTranslations('title', $this->normalizeTranslations($this->form['title']));
        $property->setTranslations('description', $this->normalizeTranslations($this->form['description']));
        $property->setTranslations('meta_title', $this->normalizeTranslations($this->form['meta_title']));
        $property->setTranslations('meta_description', $this->normalizeTranslations($this->form['meta_description']));
        $property->save();

        Cache::forget("property.{$property->slug}");
        Cache::forget('homepage.featured');
        session()->flash('status', 'Property saved successfully.');

        return $this->redirectRoute('admin.properties.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.property-form', [
            'propertyTypes' => ['flat', 'studio', 'house', 'duplex', 'penthouse', 'bungalow', 'other'],
            'statuses' => ['for_sale', 'for_rent', 'sold', 'rented', 'new'],
        ])->layout('components.layouts.admin', ['title' => $this->property ? 'Edit Property' : 'Create Property']);
    }
}
