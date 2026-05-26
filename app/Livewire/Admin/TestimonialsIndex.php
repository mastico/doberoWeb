<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TestimonialsIndex extends Component
{
    public function delete(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
        Cache::forget('homepage.testimonials');
        session()->flash('status', 'Testimonial deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.testimonials-index', [
            'testimonials' => Testimonial::ordered()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Testimonials']);
    }
}
