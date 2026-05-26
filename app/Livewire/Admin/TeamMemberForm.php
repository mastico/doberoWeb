<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\TeamMember;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamMemberForm extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public ?TeamMember $member = null;

    public array $form = [];

    public $photoUpload;

    public function mount(?TeamMember $member = null): void
    {
        $this->member = $member?->exists ? $member : null;
        $this->form = [
            'name' => $this->member?->name ?? '',
            'role' => $this->member ? $this->fillTranslations($this->member->getTranslations('role')) : $this->blankTranslations(),
            'bio' => $this->member ? $this->fillTranslations($this->member->getTranslations('bio')) : $this->blankTranslations(),
            'photo' => $this->member?->photo ?? '',
            'sort_order' => $this->member?->sort_order ?? 0,
            'is_active' => $this->member?->is_active ?? true,
        ];
    }

    public function save()
    {
        $rules = [
            'form.name' => ['required', 'string', 'max:255'],
            'form.sort_order' => ['required', 'integer'],
            'form.is_active' => ['boolean'],
            'photoUpload' => ['nullable', 'image', 'max:2048'],
        ];

        foreach ($this->localeKeys() as $locale) {
            $rules["form.role.{$locale}"] = [$locale === default_locale() ? 'required' : 'nullable', 'string', 'max:255'];
            $rules["form.bio.{$locale}"] = ['nullable', 'string'];
        }

        $this->validate($rules);

        if ($this->photoUpload) {
            $this->form['photo'] = $this->photoUpload->store('team', 'public');
        }

        $member = TeamMember::updateOrCreate(['id' => $this->member?->id], Arr::except($this->form, ['role', 'bio']));
        $member->setTranslations('role', $this->normalizeTranslations($this->form['role']));
        $member->setTranslations('bio', $this->normalizeTranslations($this->form['bio']));
        $member->save();

        Cache::forget('homepage.agents');
        session()->flash('status', 'Team member saved successfully.');

        return $this->redirectRoute('admin.team.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.team-member-form')->layout('components.layouts.admin', ['title' => $this->member ? 'Edit Team Member' : 'Create Team Member']);
    }
}
