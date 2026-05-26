<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\FaqItem;
use Illuminate\Support\Arr;
use Livewire\Component;

class FaqItemForm extends Component
{
    use HandlesTranslations;

    public ?FaqItem $faq = null;

    public string $activeLocale = 'en';

    public array $form = [
        'page' => 'relocation',
        'question' => ['en' => '', 'es' => '', 'hu' => ''],
        'answer' => ['en' => '', 'es' => '', 'hu' => ''],
        'sort_order' => 0,
        'is_active' => true,
    ];

    public function mount(?FaqItem $faq = null): void
    {
        $this->faq = $faq?->exists ? $faq : null;

        if (! $this->faq) {
            return;
        }

        $this->form = [
            'page' => $this->faq->page,
            'question' => $this->fillTranslations($this->faq->getTranslations('question')),
            'answer' => $this->fillTranslations($this->faq->getTranslations('answer')),
            'sort_order' => $this->faq->sort_order,
            'is_active' => $this->faq->is_active,
        ];
    }

    public function save(): void
    {
        $rules = [
            'form.page' => ['required', 'string', 'max:255'],
            'form.sort_order' => ['required', 'integer', 'min:0'],
            'form.is_active' => ['boolean'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $required = $locale === default_locale() ? 'required' : 'nullable';
            $rules["form.question.{$locale}"] = [$required, 'string', 'max:500'];
            $rules["form.answer.{$locale}"] = [$required, 'string'];
        }

        $this->validate($rules);

        $faq = FaqItem::updateOrCreate(
            ['id' => $this->faq?->id],
            Arr::except($this->form, ['question', 'answer'])
        );

        $faq->setTranslations('question', $this->normalizeTranslations($this->form['question']));
        $faq->setTranslations('answer', $this->normalizeTranslations($this->form['answer']));
        $faq->save();

        session()->flash('status', 'FAQ item saved.');
        $this->redirectRoute('admin.faqs.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.faq-item-form', [
            'pageOptions' => ['relocation', 'construction', 'about', 'home', 'contact'],
        ])->layout('components.layouts.admin', ['title' => $this->faq ? 'Edit FAQ' : 'Create FAQ']);
    }
}
