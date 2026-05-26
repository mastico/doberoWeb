<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;

class ServicesIndex extends Component
{
    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        session()->flash('status', 'Service deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.services-index', [
            'services' => Service::ordered()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Services']);
    }
}
