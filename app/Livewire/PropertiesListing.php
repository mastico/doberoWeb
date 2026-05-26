<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PropertiesListing extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $keyword = '';

    #[Url(as: 'type')]
    public string $type = '';

    #[Url(as: 'status')]
    public string $status = '';

    #[Url(as: 'min')]
    public ?int $minPrice = null;

    #[Url(as: 'max')]
    public ?int $maxPrice = null;

    public bool $showAdvanced = false;

    public string $sort = 'latest';

    public string $viewMode = 'grid';

    public function updatingKeyword(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatingMaxPrice(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::query()
            ->when($this->keyword !== '', function ($query): void {
                $query->where(function ($query): void {
                    $query->where('title', 'like', '%'.$this->keyword.'%')
                        ->orWhere('city', 'like', '%'.$this->keyword.'%')
                        ->orWhere('address', 'like', '%'.$this->keyword.'%')
                        ->orWhere('description', 'like', '%'.$this->keyword.'%');
                });
            })
            ->when($this->type !== '', fn ($query) => $query->where('property_type', $this->type))
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->when($this->minPrice, fn ($query) => $query->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn ($query) => $query->where('price', '<=', $this->maxPrice));

        $query = match ($this->sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };

        $properties = $query->paginate(6);

        return view('livewire.properties-listing', [
            'properties' => $properties,
            'propertyTypes' => ['house', 'flat', 'villa', 'apartment', 'commercial', 'land'],
            'statuses' => ['for_sale', 'for_rent', 'sold', 'rented'],
        ])->layout('components.layouts.app', [
            'title' => 'Properties',
            'canonical' => route('properties.index'),
        ]);
    }
}
