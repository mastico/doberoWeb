<?php

namespace App\Livewire\Admin;

use App\Models\FaqItem;
use Livewire\Component;

class FaqItemsIndex extends Component
{
    public string $filterPage = '';

    public function delete(int $id): void
    {
        FaqItem::findOrFail($id)->delete();
        session()->flash('status', 'FAQ item deleted.');
    }

    public function render()
    {
        $query = FaqItem::ordered();

        if ($this->filterPage !== '') {
            $query->forPage($this->filterPage);
        }

        return view('livewire.admin.faq-items-index', [
            'faqs' => $query->get(),
            'pages' => FaqItem::distinct()->orderBy('page')->pluck('page'),
        ])->layout('components.layouts.admin', ['title' => 'FAQ Items']);
    }
}
