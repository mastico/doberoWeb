<?php

namespace App\Livewire;

use App\Models\BlogPost;
use App\Models\PageSection;
use App\Models\Property;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class Homepage extends Component
{
    public array $sections = [];

    public function mount(): void
    {
        foreach ([
            'hero', 'mission', 'expertise', 'services_banner', 'investment', 'contact', 'featured_grid', 'agents', 'testimonials', 'partners',
        ] as $sectionKey) {
            $this->sections[$sectionKey] = PageSection::getSection('home', $sectionKey);
        }
    }

    public function render()
    {
        return view('livewire.homepage', [
            'featuredProperties' => $this->tableExists('properties')
                ? Cache::rememberForever('homepage.featured', fn () => Property::featured()->latest()->take(9)->get())
                : new Collection,
            'agents' => $this->tableExists('team_members')
                ? Cache::rememberForever('homepage.agents', fn () => TeamMember::active()->ordered()->take(4)->get())
                : new Collection,
            'testimonials' => $this->tableExists('testimonials')
                ? Cache::rememberForever('homepage.testimonials', fn () => Testimonial::active()->ordered()->take(3)->get())
                : new Collection,
            'services' => $this->tableExists('services')
                ? Cache::rememberForever('homepage.services', fn () => Service::active()->ordered()->take(4)->get())
                : new Collection,
            'posts' => $this->tableExists('blog_posts')
                ? Cache::rememberForever('homepage.posts', fn () => BlogPost::published()->latest('published_at')->take(4)->get())
                : new Collection,
        ])->layout('components.layouts.app', ['title' => 'Home']);
    }

    protected function tableExists(string $table): bool
    {
        return Schema::hasTable($table);
    }
}
