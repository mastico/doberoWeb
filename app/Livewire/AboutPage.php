<?php

namespace App\Livewire;

use App\Models\PageSection;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class AboutPage extends Component
{
    public array $sections = [];

    public function mount(): void
    {
        foreach (['header', 'intro', 'team', 'testimonials', 'partners'] as $key) {
            $this->sections[$key] = PageSection::getSection('about', $key);
        }
    }

    public function render()
    {
        return view('livewire.about', [
            'teamMembers' => Schema::hasTable('team_members') ? TeamMember::active()->ordered()->get() : new Collection,
            'testimonials' => Schema::hasTable('testimonials') ? Testimonial::active()->ordered()->take(3)->get() : new Collection,
        ])->layout('components.layouts.app', ['title' => __('About Us')]);
    }
}
