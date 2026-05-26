<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ServicesIndex extends Component
{
    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        Cache::forget('homepage.services');
        session()->flash('status', 'Service deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.services-index', [
            'services' => Service::ordered()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Services']);
    }
}
