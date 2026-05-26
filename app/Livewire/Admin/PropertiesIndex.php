<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertiesIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Property::findOrFail($id)->delete();
        session()->flash('status', 'Property deleted successfully.');
    }

    public function render()
    {
        $properties = Property::query()
            ->when($this->search !== '', function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('city', 'like', '%'.$this->search.'%')
                    ->orWhere('property_id_ref', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.properties-index', ['properties' => $properties])
            ->layout('components.layouts.admin', ['title' => 'Properties']);
    }
}
