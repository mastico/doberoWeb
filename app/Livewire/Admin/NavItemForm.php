<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\NavItem;
use Illuminate\Support\Arr;
use Livewire\Component;

class NavItemForm extends Component
{
    use HandlesTranslations;

    public ?NavItem $item = null;

    public string $activeLocale = 'en';

    public array $form = [
        'parent_id' => null,
        'location' => 'primary',
        'label' => ['en' => '', 'es' => '', 'hu' => ''],
        'url' => ['en' => '', 'es' => '', 'hu' => ''],
        'sort_order' => 0,
        'is_active' => true,
        'opens_in_new_tab' => false,
    ];

    public function mount(?NavItem $item = null): void
    {
        $this->item = $item?->exists ? $item : null;

        if (! $this->item) {
            $this->form['label'] = $this->blankTranslations();
            $this->form['url'] = $this->blankTranslations();

            return;
        }

        $this->form = [
            'parent_id' => $this->item->parent_id,
            'location' => $this->item->location,
            'label' => $this->fillTranslations($this->item->getTranslations('label')),
            'url' => $this->fillTranslations($this->item->getTranslations('url')),
            'sort_order' => $this->item->sort_order,
            'is_active' => $this->item->is_active,
            'opens_in_new_tab' => $this->item->opens_in_new_tab,
        ];
    }

    public function save()
    {
        $rules = [
            'form.parent_id' => ['nullable', 'integer', 'exists:nav_items,id'],
            'form.location' => ['required', 'string', 'max:255'],
            'form.sort_order' => ['required', 'integer', 'min:0'],
            'form.is_active' => ['boolean'],
            'form.opens_in_new_tab' => ['boolean'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.label.{$locale}"] = ['required', 'string', 'max:255'];
            $rules["form.url.{$locale}"] = ['required', 'string', 'max:255'];
        }

        $validated = $this->validate($rules);
        $item = NavItem::updateOrCreate(['id' => $this->item?->id], Arr::except($validated['form'], ['label', 'url']));
        $item->setTranslations('label', $this->normalizeTranslations($this->form['label']));
        $item->setTranslations('url', $this->normalizeTranslations($this->form['url']));
        $item->save();

        session()->flash('status', 'Navigation item saved successfully.');

        return $this->redirectRoute('admin.navigation.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.nav-item-form', [
            'rootItems' => NavItem::roots()
                ->when($this->item?->exists, fn ($query) => $query->whereKeyNot($this->item->id))
                ->ordered()
                ->get(),
        ])->layout('components.layouts.admin', ['title' => $this->item ? 'Edit Navigation Item' : 'Create Navigation Item']);
    }
}
