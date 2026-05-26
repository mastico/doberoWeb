<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;

class PagesIndex extends Component
{
    public string $search = '';

    public function togglePublished(int $id): void
    {
        $page = Page::findOrFail($id);
        $page->update([
            'is_published' => ! $page->is_published,
            'published_at' => ! $page->is_published ? now() : null,
        ]);

        session()->flash('status', 'Page updated successfully.');
    }

    public function delete(int $id): void
    {
        $page = Page::findOrFail($id);

        if (! $page->deletable) {
            session()->flash('status', 'Core pages cannot be deleted.');

            return;
        }

        $page->delete();
        session()->flash('status', 'Page deleted successfully.');
    }

    public function render()
    {
        $term = '%'.$this->search.'%';

        return view('livewire.admin.pages-index', [
            'pages' => Page::query()
                ->when($this->search !== '', function ($query) use ($term): void {
                    $query->where(function ($query) use ($term): void {
                        $query->where('key', 'like', $term)
                            ->orWhereRaw("json_extract(title, '$.en') like ?", [$term]);
                    });
                })
                ->orderBy('sort_order')
                ->get(),
        ])->layout('components.layouts.admin', ['title' => 'Pages']);
    }
}
