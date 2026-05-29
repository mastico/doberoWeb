<?php

namespace App\Livewire;

use App\Models\ContactInquiry;
use App\Models\Property;
use App\Models\PropertyReview;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;

    public array $tour = [
        'tour_type' => 'in_person',
        'date' => '',
        'time' => '',
        'name' => '',
        'phone' => '',
        'email' => '',
        'message' => '',
    ];

    public array $reviewForm = [
        'title' => '',
        'rating' => 5,
        'review' => '',
        'author_name' => '',
        'author_email' => '',
    ];

    public array $inquiry = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
    ];

    public function mount(string $slug): void
    {
        $id = Cache::remember(
            "property.slug.{$slug}",
            now()->addMinutes(5),
            fn () => Property::where('slug', $slug)->firstOrFail()->id
        );

        $this->property = Property::findOrFail($id);
    }

    public function submitTour(): void
    {
        $data = $this->validate([
            'tour.tour_type' => ['required', 'string'],
            'tour.date' => ['required', 'date'],
            'tour.time' => ['required'],
            'tour.name' => ['required', 'string', 'max:255'],
            'tour.phone' => ['nullable', 'string', 'max:255'],
            'tour.email' => ['required', 'email', 'max:255'],
            'tour.message' => ['nullable', 'string'],
        ]);

        [$firstName, $lastName] = array_pad(explode(' ', $data['tour']['name'], 2), 2, '');

        ContactInquiry::create([
            'inquiry_type' => 'tour:'.$data['tour']['tour_type'],
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $data['tour']['email'],
            'phone' => $data['tour']['phone'] ?: null,
            'message' => 'Tour request on '.$data['tour']['date'].' at '.$data['tour']['time'].'. '.$data['tour']['message'],
            'property_id' => $this->property->id,
        ]);

        $this->tour = ['tour_type' => 'in_person', 'date' => '', 'time' => '', 'name' => '', 'phone' => '', 'email' => '', 'message' => ''];
        session()->flash('tour_success', 'Your tour request has been sent.');
    }

    public function submitReview(): void
    {
        $data = $this->validate([
            'reviewForm.title' => ['required', 'string', 'max:255'],
            'reviewForm.rating' => ['required', 'integer', 'between:1,5'],
            'reviewForm.review' => ['required', 'string'],
            'reviewForm.author_name' => ['required', 'string', 'max:255'],
            'reviewForm.author_email' => ['required', 'email', 'max:255'],
        ]);

        PropertyReview::create($data['reviewForm'] + [
            'property_id' => $this->property->id,
            'is_approved' => false,
        ]);

        $this->reviewForm = ['title' => '', 'rating' => 5, 'review' => '', 'author_name' => '', 'author_email' => ''];
        session()->flash('review_success', 'Thanks! Your review is awaiting approval.');
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
            'approvedReviews' => $this->property->approvedReviews()->latest()->get(),
        ])->layout('components.layouts.app', [
            'title' => $this->property->title,
            'description' => $metaDesc,
            'canonical' => $canonical,
        ]);
    }
}
