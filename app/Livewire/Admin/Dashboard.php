<?php

namespace App\Livewire\Admin;

use App\Models\BlogPost;
use App\Models\ContactInquiry;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => [
                'properties' => Property::count(),
                'agents' => TeamMember::count(),
                'testimonials' => Testimonial::count(),
                'inquiries' => ContactInquiry::count(),
                'posts' => BlogPost::count(),
            ],
            'recentInquiries' => ContactInquiry::latest()->take(5)->get(),
            'recentProperties' => Property::latest()->take(5)->get(),
        ])->layout('components.layouts.admin', ['title' => 'Dashboard']);
    }
}
