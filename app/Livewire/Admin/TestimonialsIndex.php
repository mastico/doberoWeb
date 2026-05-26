<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;

class TestimonialsIndex extends Component
{
    public function delete(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
        session()->flash('status', 'Testimonial deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.testimonials-index', [
            'testimonials' => Testimonial::ordered()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Testimonials']);
    }
}
