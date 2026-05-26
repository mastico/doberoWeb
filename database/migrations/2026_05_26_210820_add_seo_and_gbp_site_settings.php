<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $locales = config('locales.available', ['en' => [], 'es' => [], 'hu' => []]);
        $default = config('locales.default', 'en');

        $blank = collect($locales)->mapWithKeys(fn ($v, $k) => [$k => ''])->toJson();

        $rows = [
            ['key' => 'seo_default_title',       'type' => 'text',     'is_translatable' => true,  'value' => $blank],
            ['key' => 'seo_default_description',  'type' => 'textarea', 'is_translatable' => true,  'value' => $blank],
            ['key' => 'gbp_url',                  'type' => 'text',     'is_translatable' => false, 'value' => json_encode([$default => ''])],
        ];

        foreach ($rows as $row) {
            DB::table('site_settings')->insertOrIgnore(array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', ['seo_default_title', 'seo_default_description', 'gbp_url'])->delete();
    }
};

