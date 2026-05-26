<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\Page;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PageForm extends Component
{
    use HandlesTranslations;

    public ?Page $page = null;

    public string $activeLocale = 'en';

    public array $form = [
        'key' => '',
        'slug' => ['en' => '', 'es' => '', 'hu' => ''],
        'title' => ['en' => '', 'es' => '', 'hu' => ''],
        'body' => ['en' => '', 'es' => '', 'hu' => ''],
        'meta_title' => ['en' => '', 'es' => '', 'hu' => ''],
        'meta_description' => ['en' => '', 'es' => '', 'hu' => ''],
        'is_published' => false,
        'sort_order' => 0,
    ];

    public function mount(?Page $page = null): void
    {
        $this->page = $page?->exists ? $page : null;

        if (! $this->page) {
            return;
        }

        $this->form = [
            'key' => $this->page->key,
            'slug' => $this->fillTranslations($this->page->getTranslations('slug')),
            'title' => $this->fillTranslations($this->page->getTranslations('title')),
            'body' => $this->fillTranslations($this->page->getTranslations('body')),
            'meta_title' => $this->fillTranslations($this->page->getTranslations('meta_title')),
            'meta_description' => $this->fillTranslations($this->page->getTranslations('meta_description')),
            'is_published' => $this->page->is_published,
            'sort_order' => $this->page->sort_order,
        ];
    }

    public function save()
    {
        $rules = [
            'form.key' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pages', 'key')->ignore($this->page?->id),
            ],
            'form.is_published' => ['boolean'],
            'form.sort_order' => ['required', 'integer', 'min:0'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.slug.{$locale}"] = ['required', 'string', 'max:255'];
            $rules["form.title.{$locale}"] = ['required', 'string', 'max:255'];
            $rules["form.body.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string'];
            $rules["form.meta_title.{$locale}"] = ['nullable', 'string', 'max:255'];
            $rules["form.meta_description.{$locale}"] = ['nullable', 'string'];
        }

        $validated = $this->validate($rules);

        if ($this->page?->exists && ! $this->page->deletable) {
            $validated['form']['key'] = $this->page->key;
        }

        $page = Page::updateOrCreate(
            ['id' => $this->page?->id],
            Arr::except($validated['form'], ['slug', 'title', 'body', 'meta_title', 'meta_description']) + [
                'published_at' => $validated['form']['is_published'] ? ($this->page?->published_at ?? now()) : null,
            ]
        );

        $page->setTranslations('slug', $this->normalizeTranslations($this->form['slug']));
        $page->setTranslations('title', $this->normalizeTranslations($this->form['title']));
        $page->setTranslations('body', $this->normalizeTranslations($this->form['body']));
        $page->setTranslations('meta_title', $this->normalizeTranslations($this->form['meta_title']));
        $page->setTranslations('meta_description', $this->normalizeTranslations($this->form['meta_description']));
        $page->save();

        session()->flash('status', 'Page saved successfully.');

        return $this->redirectRoute('admin.pages.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.page-form')->layout('components.layouts.admin', ['title' => $this->page ? 'Edit Page' : 'Create Page']);
    }
}
