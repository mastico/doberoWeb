<?php

namespace App\Livewire;

use App\Models\ContactInquiry;
use Livewire\Component;

class ContactForm extends Component
{
    public ?string $inquiry_type = null;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public ?string $phone = null;

    public ?string $message = null;

    public ?string $min_price = null;

    public ?string $max_price = null;

    public ?int $bedrooms = null;

    public ?int $bathrooms = null;

    public function submit(): void
    {
        $validated = $this->validate([
            'inquiry_type' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'min_price' => ['nullable', 'numeric'],
            'max_price' => ['nullable', 'numeric'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
        ]);

        ContactInquiry::create($validated);

        $this->reset(['inquiry_type', 'first_name', 'last_name', 'email', 'phone', 'message', 'min_price', 'max_price', 'bedrooms', 'bathrooms']);
        session()->flash('contact_success', 'Thanks for your inquiry. We will contact you soon.');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
