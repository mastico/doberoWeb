<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add temporary JSON columns
        Schema::table('page_sections', function (Blueprint $table) {
            $table->json('title_tmp')->nullable()->after('section_key');
            $table->json('subtitle_tmp')->nullable()->after('title_tmp');
            $table->json('content_tmp')->nullable()->after('subtitle_tmp');
        });

        // Backfill existing English values
        DB::table('page_sections')->orderBy('id')->each(function ($row) {
            DB::table('page_sections')->where('id', $row->id)->update([
                'title_tmp' => $row->title ? json_encode(['en' => $row->title]) : null,
                'subtitle_tmp' => $row->subtitle ? json_encode(['en' => $row->subtitle]) : null,
                'content_tmp' => $row->content ? json_encode(['en' => $row->content]) : null,
            ]);
        });

        // Drop old string/text columns
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'content']);
        });

        // Rename tmp columns to final names
        Schema::table('page_sections', function (Blueprint $table) {
            $table->renameColumn('title_tmp', 'title');
            $table->renameColumn('subtitle_tmp', 'subtitle');
            $table->renameColumn('content_tmp', 'content');
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->string('title_rev')->nullable()->after('section_key');
            $table->string('subtitle_rev')->nullable()->after('title_rev');
            $table->text('content_rev')->nullable()->after('subtitle_rev');
        });

        DB::table('page_sections')->orderBy('id')->each(function ($row) {
            $title = $row->title ? json_decode($row->title, true) : null;
            $subtitle = $row->subtitle ? json_decode($row->subtitle, true) : null;
            $content = $row->content ? json_decode($row->content, true) : null;
            DB::table('page_sections')->where('id', $row->id)->update([
                'title_rev' => is_array($title) ? ($title['en'] ?? null) : $title,
                'subtitle_rev' => is_array($subtitle) ? ($subtitle['en'] ?? null) : $subtitle,
                'content_rev' => is_array($content) ? ($content['en'] ?? null) : $content,
            ]);
        });

        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'content']);
        });

        Schema::table('page_sections', function (Blueprint $table) {
            $table->renameColumn('title_rev', 'title');
            $table->renameColumn('subtitle_rev', 'subtitle');
            $table->renameColumn('content_rev', 'content');
        });
    }
};
