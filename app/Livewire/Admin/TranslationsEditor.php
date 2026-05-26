<?php

namespace App\Livewire\Admin;

use App\Services\TranslationFileManager;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TranslationsEditor extends Component
{
    public string $group = 'global';

    public string $search = '';

    public array $rows = [];

    /** All rows for the current group (unfiltered, used for save). */
    protected array $allRows = [];

    public function mount(): void
    {
        $this->loadGroup();
    }

    public function updatedGroup(): void
    {
        $this->search = '';
        $this->loadGroup();
    }

    public function updatedSearch(): void
    {
        // allRows is a protected property not tracked by Livewire between requests,
        // so reload from cache before filtering.
        $this->loadGroup();
    }

    public function save(): void
    {
        $manager = app(TranslationFileManager::class);

        // Load the full group from cache (fast), then merge in the edited visible rows.
        // $allRows is protected and not tracked by Livewire between requests, so we
        // must reload here rather than rely on the property being populated.
        $all = $manager->getGroup($this->group);
        $edited = collect($this->rows)->keyBy('key')->toArray();

        foreach ($all as &$row) {
            if (isset($edited[$row['key']])) {
                $row['en'] = $edited[$row['key']]['en'];
                $row['es'] = $edited[$row['key']]['es'];
                $row['hu'] = $edited[$row['key']]['hu'];
            }
        }
        unset($row);

        $manager->saveGroup($this->group, $all);
        $this->loadGroup(); // re-read from files to confirm

        session()->flash('status', 'Translations saved successfully.');
    }

    #[Computed]
    public function groups(): array
    {
        return app(TranslationFileManager::class)->listGroups();
    }

    public function render()
    {
        return view('livewire.admin.translations-editor')
            ->layout('components.layouts.admin', ['title' => 'Translations']);
    }

    // ─── Private ─────────────────────────────────────────────────────────────

    private function loadGroup(): void
    {
        $this->allRows = app(TranslationFileManager::class)->getGroup($this->group);
        $this->applySearch();
    }

    private function applySearch(): void
    {
        if (trim($this->search) === '') {
            $this->rows = $this->allRows;

            return;
        }

        $q = mb_strtolower($this->search);
        $this->rows = array_values(array_filter(
            $this->allRows,
            fn (array $row) => str_contains(mb_strtolower($row['key']), $q)
                || str_contains(mb_strtolower($row['en']), $q)
                || str_contains(mb_strtolower($row['es']), $q)
                || str_contains(mb_strtolower($row['hu']), $q),
        ));
    }
}
