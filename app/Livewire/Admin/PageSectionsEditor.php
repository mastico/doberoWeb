<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\PageSection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PageSectionsEditor extends Component
{
    use HandlesTranslations;

    public string $page = 'home';

    public string $activeLocale = 'en';

    public ?int $selectedSectionId = null;

    public array $form = [
        'title' => ['en' => '', 'es' => '', 'hu' => ''],
        'subtitle' => ['en' => '', 'es' => '', 'hu' => ''],
        'content' => ['en' => '', 'es' => '', 'hu' => ''],
        'extra' => '{}',
        'sort_order' => 0,
        'is_active' => true,
    ];

    public function mount(): void
    {
        $this->resetForm();
        $this->loadFirstSection();
    }

    public function updatedPage(): void
    {
        $this->resetForm();
        $this->loadFirstSection();
    }

    public function selectSection(int $id): void
    {
        $section = PageSection::findOrFail($id);
        $this->selectedSectionId = $section->id;
        $this->form = [
            'title' => $this->fillTranslations($section->getTranslations('title')),
            'subtitle' => $this->fillTranslations($section->getTranslations('subtitle')),
            'content' => $this->fillTranslations($section->getTranslations('content')),
            'extra' => json_encode($section->extra ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order' => $section->sort_order,
            'is_active' => $section->is_active,
        ];
    }

    protected function loadFirstSection(): void
    {
        $first = PageSection::where('page', $this->page)->orderBy('sort_order')->first();

        if ($first) {
            $this->selectSection($first->id);

            return;
        }

        $this->selectedSectionId = null;
    }

    public function save(): void
    {
        $rules = [
            'form.extra' => ['nullable', 'string'],
            'form.sort_order' => ['required', 'integer'],
            'form.is_active' => ['boolean'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.title.{$locale}"] = ['nullable', 'string', 'max:255'];
            $rules["form.subtitle.{$locale}"] = ['nullable', 'string', 'max:255'];
            $rules["form.content.{$locale}"] = ['nullable', 'string'];
        }

        $this->validate($rules);

        $decoded = $this->form['extra'] ? json_decode($this->form['extra'], true) : [];

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError('form.extra', 'Extra must be valid JSON.');

            return;
        }

        $section = PageSection::findOrFail($this->selectedSectionId);
        $section->setTranslations('title', $this->normalizeTranslations($this->form['title']));
        $section->setTranslations('subtitle', $this->normalizeTranslations($this->form['subtitle']));
        $section->setTranslations('content', $this->normalizeTranslations($this->form['content']));
        $section->extra = $decoded;
        $section->sort_order = $this->form['sort_order'];
        $section->is_active = $this->form['is_active'];
        $section->save();

        PageSection::forgetCache($section->page, $section->section_key);
        session()->flash('status', 'Page section updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.page-sections-editor', [
            'pages' => PageSection::query()->select('page')->distinct()->pluck('page'),
            'sections' => PageSection::where('page', $this->page)->orderBy('sort_order')->get(),
        ])->layout('components.layouts.admin', ['title' => 'Page Sections']);
    }

    protected function resetForm(): void
    {
        $this->form = [
            'title' => $this->blankTranslations(),
            'subtitle' => $this->blankTranslations(),
            'content' => $this->blankTranslations(),
            'extra' => '{}',
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
