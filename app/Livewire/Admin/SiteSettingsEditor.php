<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\HandlesTranslations;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteSettingsEditor extends Component
{
    use HandlesTranslations;
    use WithFileUploads;

    public string $activeLocale = 'en';

    public array $settings = [];

    public $logoUpload;

    public function mount(): void
    {
        $this->settings = SiteSetting::orderBy('key')->get()->mapWithKeys(function (SiteSetting $setting): array {
            if ($setting->is_translatable) {
                return [$setting->key => $this->fillTranslations($setting->getTranslations('value'))];
            }

            return [$setting->key => $setting->getTranslation('value', default_locale(), false)];
        })->toArray();
    }

    public function save(): void
    {
        $records = SiteSetting::orderBy('key')->get()->keyBy('key');

        foreach ($this->settings as $key => $value) {
            $setting = $records[$key] ?? null;

            if (! $setting) {
                continue;
            }

            if ($setting->is_translatable) {
                $setting->setTranslations('value', $this->normalizeTranslations($value));
            } else {
                $setting->setTranslation('value', default_locale(), $value ?? '');
            }

            $setting->save();

            SiteSetting::forgetCache($key);
        }

        if ($this->logoUpload) {
            SiteSetting::set('logo', $this->logoUpload->store('settings', 'public'), 'image');
            SiteSetting::forgetCache('logo');
        }

        session()->flash('status', 'Site settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.site-settings-editor', [
            'records' => SiteSetting::orderBy('key')->get(),
        ])->layout('components.layouts.admin', ['title' => 'Site Settings']);
    }
}
