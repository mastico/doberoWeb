<?php

use Database\Seeders\LegalComplianceData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        if (Schema::hasTable('pages')) {
            foreach (LegalComplianceData::pages() as $page) {
                if (DB::table('pages')->where('key', $page['key'])->exists()) {
                    continue;
                }

                DB::table('pages')->insert([
                    'key' => $page['key'],
                    'slug' => $this->encode($page['slug']),
                    'title' => $this->encode($page['title']),
                    'body' => $this->encode($page['body']),
                    'meta_title' => $this->encode($page['meta_title']),
                    'meta_description' => $this->encode($page['meta_description']),
                    'is_published' => true,
                    'published_at' => $now,
                    'deletable' => $page['deletable'],
                    'sort_order' => $page['sort_order'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('site_settings')) {
            foreach (LegalComplianceData::settings() as $setting) {
                if (DB::table('site_settings')->where('key', $setting['key'])->exists()) {
                    continue;
                }

                DB::table('site_settings')->insert([
                    'key' => $setting['key'],
                    'value' => $this->encode($setting['value']),
                    'type' => $setting['type'],
                    'is_translatable' => $setting['is_translatable'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Legal records may have been edited since this migration ran; never remove them on rollback.
    }

    private function encode(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
};
