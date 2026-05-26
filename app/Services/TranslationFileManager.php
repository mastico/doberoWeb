<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class TranslationFileManager
{
    const LOCALES = ['en', 'es', 'hu'];

    const CACHE_TAG = 'translations';

    /**
     * List all groups with their key counts.
     *
     * @return array<string, int> e.g. ['global' => 23, 'relocation' => 129, ...]
     */
    public function listGroups(): array
    {
        $config = config('translation_pages');
        $groups = [];

        foreach ($config['php_groups'] as $group) {
            $data = $this->loadPhpGroup($group, 'en');
            $groups[$group] = count($data);
        }

        foreach ($config['json_groups'] as $group) {
            $keys = $config['json_key_groups'][$group] ?? [];
            $groups[$group] = count($keys);
        }

        return $groups;
    }

    /**
     * Load all rows for a group across all locales.
     *
     * Returns array of ['key' => string, 'en' => string, 'es' => string, 'hu' => string]
     */
    public function getGroup(string $group): array
    {
        return Cache::rememberForever($this->cacheKey($group), function () use ($group) {
            return $this->loadGroupRows($group);
        });
    }

    /**
     * Save edited rows back to the lang files and bust the cache.
     *
     * @param  array  $rows  array of ['key' => string, 'en' => string, 'es' => string, 'hu' => string]
     */
    public function saveGroup(string $group, array $rows): void
    {
        $phpGroups = config('translation_pages.php_groups', []);

        if (in_array($group, $phpGroups)) {
            $this->savePhpGroupRows($group, $rows);
        } else {
            $this->saveJsonGroupRows($group, $rows);
        }

        Cache::forget($this->cacheKey($group));
        $this->resetTranslator();
    }

    // ─── Private ─────────────────────────────────────────────────────────────

    private function cacheKey(string $group): string
    {
        return self::CACHE_TAG.'.'.$group;
    }

    private function loadGroupRows(string $group): array
    {
        $phpGroups = config('translation_pages.php_groups', []);

        if (in_array($group, $phpGroups)) {
            return $this->loadPhpGroupRows($group);
        }

        return $this->loadJsonGroupRows($group);
    }

    // ── PHP file groups ───────────────────────────────────────────────────────

    private function loadPhpGroupRows(string $group): array
    {
        $byLocale = [];
        foreach (self::LOCALES as $locale) {
            $path = lang_path("{$locale}/{$group}.php");
            $byLocale[$locale] = file_exists($path) ? $this->flattenArray(require $path) : [];
        }

        $keys = array_unique(array_merge(
            array_keys($byLocale['en']),
            array_keys($byLocale['es']),
            array_keys($byLocale['hu']),
        ));
        sort($keys);

        $rows = [];
        foreach ($keys as $key) {
            $rows[] = [
                'key' => $key,
                'en' => $byLocale['en'][$key] ?? '',
                'es' => $byLocale['es'][$key] ?? '',
                'hu' => $byLocale['hu'][$key] ?? '',
            ];
        }

        return $rows;
    }

    private function savePhpGroupRows(string $group, array $rows): void
    {
        foreach (self::LOCALES as $locale) {
            $flat = [];
            foreach ($rows as $row) {
                $flat[$row['key']] = $row[$locale] ?? '';
            }
            $nested = $this->unflattenArray($flat);
            $path = lang_path("{$locale}/{$group}.php");
            $this->backupFile($path);
            file_put_contents($path, "<?php\n\nreturn ".$this->exportArray($nested).";\n");
        }
    }

    // ── JSON file groups ──────────────────────────────────────────────────────

    private function loadJsonGroupRows(string $group): array
    {
        $keys = config("translation_pages.json_key_groups.{$group}", []);

        $byLocale = [];
        foreach (self::LOCALES as $locale) {
            $path = lang_path("{$locale}.json");
            $byLocale[$locale] = file_exists($path)
                ? json_decode(file_get_contents($path), true) ?? []
                : [];
        }

        $rows = [];
        foreach ($keys as $key) {
            $rows[] = [
                'key' => $key,
                'en' => $byLocale['en'][$key] ?? $key,  // EN falls back to key itself
                'es' => $byLocale['es'][$key] ?? '',
                'hu' => $byLocale['hu'][$key] ?? '',
            ];
        }

        return $rows;
    }

    private function saveJsonGroupRows(string $group, array $rows): void
    {
        foreach (self::LOCALES as $locale) {
            $path = lang_path("{$locale}.json");
            $existing = file_exists($path)
                ? json_decode(file_get_contents($path), true) ?? []
                : [];

            foreach ($rows as $row) {
                $existing[$row['key']] = $row[$locale] ?? '';
            }

            $this->backupFile($path);
            file_put_contents($path, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");
        }
    }

    // ── Array helpers ─────────────────────────────────────────────────────────

    /**
     * Flatten a nested array to dot-notation keys.
     * ['nav' => ['title' => 'X']] → ['nav.title' => 'X']
     */
    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $fullKey = $prefix !== '' ? "{$prefix}.{$key}" : (string) $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $fullKey));
            } else {
                $result[$fullKey] = (string) $value;
            }
        }

        return $result;
    }

    /**
     * Rebuild a nested array from dot-notation keys.
     * ['nav.title' => 'X'] → ['nav' => ['title' => 'X']]
     */
    private function unflattenArray(array $flat): array
    {
        $result = [];
        foreach ($flat as $key => $value) {
            $parts = explode('.', $key);
            $current = &$result;
            foreach ($parts as $part) {
                if (! isset($current[$part]) || ! is_array($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }
            $current = $value;
        }

        return $result;
    }

    /**
     * Export a PHP array as a pretty-printed string (like var_export but cleaner).
     */
    private function exportArray(array $array, int $indent = 0): string
    {
        $pad = str_repeat('    ', $indent);
        $pad1 = str_repeat('    ', $indent + 1);
        $lines = ['['];
        foreach ($array as $key => $value) {
            $k = var_export($key, true);
            if (is_array($value)) {
                $lines[] = "{$pad1}{$k} => ".$this->exportArray($value, $indent + 1).',';
            } else {
                $v = var_export($value, true);
                $lines[] = "{$pad1}{$k} => {$v},";
            }
        }
        $lines[] = "{$pad}]";

        return implode("\n", $lines);
    }

    /**
     * Clear Laravel's in-memory loaded translations so the next request
     * re-reads from files without requiring a server restart.
     */
    private function resetTranslator(): void
    {
        try {
            app('translator')->setLoaded([]);
        } catch (\Throwable) {
            // Non-fatal — translator will refresh on next boot anyway
        }
    }

    /**
     * Copy $path → $path.2026-05-25_23-24-51.old before overwriting.
     */
    private function backupFile(string $path): void
    {
        if (! file_exists($path)) {
            return;
        }

        $stamp = now()->format('Y-m-d_H-i-s');
        $backup = "{$path}.{$stamp}.old";
        copy($path, $backup);
    }

    // ── Used by listGroups() for PHP groups ───────────────────────────────────

    private function loadPhpGroup(string $group, string $locale): array
    {
        $path = lang_path("{$locale}/{$group}.php");

        return file_exists($path) ? $this->flattenArray(require $path) : [];
    }
}
