<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LegalComplianceSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('pages') || ! Schema::hasTable('site_settings')) {
            return;
        }

        foreach (LegalComplianceData::pages() as $pageData) {
            if (Page::where('key', $pageData['key'])->exists()) {
                continue;
            }

            $page = new Page([
                'key' => $pageData['key'],
                'is_published' => true,
                'published_at' => now(),
                'deletable' => $pageData['deletable'],
                'sort_order' => $pageData['sort_order'],
            ]);
            $page->setTranslations('slug', $pageData['slug']);
            $page->setTranslations('title', $pageData['title']);
            $page->setTranslations('body', $pageData['body']);
            $page->setTranslations('meta_title', $pageData['meta_title']);
            $page->setTranslations('meta_description', $pageData['meta_description']);
            $page->save();
        }

        foreach (LegalComplianceData::settings() as $settingData) {
            if (SiteSetting::where('key', $settingData['key'])->exists()) {
                continue;
            }

            $setting = new SiteSetting([
                'key' => $settingData['key'],
                'type' => $settingData['type'],
                'is_translatable' => $settingData['is_translatable'],
            ]);
            $setting->setTranslations('value', $settingData['value']);
            $setting->save();
        }
    }
}
