<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\Service;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceForm extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public ?Service $service = null;

    public array $form = [];

    public $imageUpload;

    public function mount(?Service $service = null): void
    {
        $this->service = $service?->exists ? $service : null;
        $this->form = [
            'title' => $this->service ? $this->fillTranslations($this->service->getTranslations('title')) : $this->blankTranslations(),
            'description' => $this->service ? $this->fillTranslations($this->service->getTranslations('description')) : $this->blankTranslations(),
            'image' => $this->service?->image ?? '',
            'icon' => $this->service?->icon ?? '',
            'category' => $this->service?->category ?? '',
            'sort_order' => $this->service?->sort_order ?? 0,
            'is_active' => $this->service?->is_active ?? true,
        ];
    }

    public function save()
    {
        $rules = [
            'form.icon' => ['nullable', 'string', 'max:255'],
            'form.category' => ['nullable', 'string', 'max:255'],
            'form.sort_order' => ['required', 'integer'],
            'form.is_active' => ['boolean'],
            'imageUpload' => ['nullable', 'image', 'max:2048'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.title.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string', 'max:255'];
            $rules["form.description.{$locale}"] = ['nullable', 'string'];
        }

        $this->validate($rules);

        if ($this->imageUpload) {
            $this->form['image'] = $this->imageUpload->store('services', 'public');
        }

        $service = Service::updateOrCreate(['id' => $this->service?->id], Arr::except($this->form, ['title', 'description']));
        $service->setTranslations('title', $this->normalizeTranslations($this->form['title']));
        $service->setTranslations('description', $this->normalizeTranslations($this->form['description']));
        $service->save();

        session()->flash('status', 'Service saved successfully.');

        return $this->redirectRoute('admin.services.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.service-form')->layout('components.layouts.admin', ['title' => $this->service ? 'Edit Service' : 'Create Service']);
    }
}
