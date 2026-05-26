<?php

namespace App\Livewire\Admin\Concerns;

trait HandlesTranslations
{
    protected function localeKeys(): array
    {
        return array_keys(config('locales.available', ['en' => []]));
    }

    protected function blankTranslations(?string $value = ''): array
    {
        return array_fill_keys($this->localeKeys(), $value ?? '');
    }

    protected function fillTranslations(?array $translations = null): array
    {
        $filled = $this->blankTranslations();

        foreach ($translations ?? [] as $locale => $value) {
            if (array_key_exists($locale, $filled)) {
                $filled[$locale] = (string) ($value ?? '');
            }
        }

        return $filled;
    }

    protected function normalizeTranslations(array $translations): array
    {
        $normalized = [];

        foreach ($this->fillTranslations($translations) as $locale => $value) {
            $normalized[$locale] = filled($value) ? $value : null;
        }

        return $normalized;
    }
}
