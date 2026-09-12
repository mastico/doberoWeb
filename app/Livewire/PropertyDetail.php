<?php

namespace App\Livewire;

use App\Models\ContactInquiry;
use App\Models\Property;
use Illuminate\Support\Str;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;

    public array $inquiry = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
    ];

    public function mount(string $slug): void
    {
        // Slug format: descriptive-text-{id}  — extract trailing integer as ID
        $id = (int) Str::afterLast($slug, '-');
        abort_if($id === 0, 404);
        $this->property = Property::findOrFail($id);
    }

    public function submitInquiry(): void
    {
        $data = $this->validate([
            'inquiry.first_name' => ['required', 'string', 'max:255'],
            'inquiry.last_name' => ['required', 'string', 'max:255'],
            'inquiry.email' => ['required', 'email', 'max:255'],
            'inquiry.phone' => ['nullable', 'string', 'max:255'],
            'inquiry.message' => ['required', 'string'],
        ]);

        ContactInquiry::create($data['inquiry'] + [
            'inquiry_type' => 'property_inquiry',
            'property_id' => $this->property->id,
        ]);

        $this->inquiry = ['first_name' => '', 'last_name' => '', 'email' => '', 'phone' => '', 'message' => ''];
        session()->flash('inquiry_success', 'We have received your inquiry.');
    }

    public function render()
    {
        $metaDesc = $this->property->getTranslation('meta_description', app()->getLocale(), false)
            ?: Str::limit(strip_tags((string) $this->property->description), 160);

        $canonical = route('properties.show', ['slug' => $this->property->slug]);

        return view('livewire.property-detail', [
            'similarListings' => Property::whereKeyNot($this->property->id)
                ->where('property_type', $this->property->property_type)
                ->latest()
                ->take(4)
                ->get(),
        ])->layout('components.layouts.app', [
            'title' => $this->property->title,
            'description' => $metaDesc,
            'canonical' => $canonical,
        ]);
    }
}
