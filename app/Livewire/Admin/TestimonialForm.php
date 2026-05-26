<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\Testimonial;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestimonialForm extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public ?Testimonial $testimonial = null;

    public array $form = [];

    public $photoUpload;

    public function mount(?Testimonial $testimonial = null): void
    {
        $this->testimonial = $testimonial?->exists ? $testimonial : null;
        $this->form = [
            'content' => $this->testimonial ? $this->fillTranslations($this->testimonial->getTranslations('content')) : $this->blankTranslations(),
            'author_name' => $this->testimonial?->author_name ?? '',
            'author_role' => $this->testimonial ? $this->fillTranslations($this->testimonial->getTranslations('author_role')) : $this->blankTranslations(),
            'author_company' => $this->testimonial?->author_company ?? '',
            'author_photo' => $this->testimonial?->author_photo ?? '',
            'sort_order' => $this->testimonial?->sort_order ?? 0,
            'is_active' => $this->testimonial?->is_active ?? true,
        ];
    }

    public function save()
    {
        $rules = [
            'form.author_name' => ['required', 'string', 'max:255'],
            'form.author_company' => ['nullable', 'string', 'max:255'],
            'form.sort_order' => ['required', 'integer'],
            'form.is_active' => ['boolean'],
            'photoUpload' => ['nullable', 'image', 'max:2048'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.content.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string'];
            $rules["form.author_role.{$locale}"] = ['nullable', 'string', 'max:255'];
        }

        $this->validate($rules);

        if ($this->photoUpload) {
            $this->form['author_photo'] = $this->photoUpload->store('testimonials', 'public');
        }

        $testimonial = Testimonial::updateOrCreate(['id' => $this->testimonial?->id], Arr::except($this->form, ['content', 'author_role']));
        $testimonial->setTranslations('content', $this->normalizeTranslations($this->form['content']));
        $testimonial->setTranslations('author_role', $this->normalizeTranslations($this->form['author_role']));
        $testimonial->save();

        session()->flash('status', 'Testimonial saved successfully.');

        return $this->redirectRoute('admin.testimonials.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.testimonial-form')->layout('components.layouts.admin', ['title' => $this->testimonial ? 'Edit Testimonial' : 'Create Testimonial']);
    }
}
