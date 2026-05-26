<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── properties: title, description ───────────────────────────────
        $this->convertToJson('properties', ['title', 'description']);

        // ── blog_posts: title, excerpt, content ───────────────────────────
        $this->convertToJson('blog_posts', ['title', 'excerpt', 'content']);

        // ── services: title, description ─────────────────────────────────
        $this->convertToJson('services', ['title', 'description']);

        // ── team_members: role, bio ───────────────────────────────────────
        $this->convertToJson('team_members', ['role', 'bio']);

        // ── testimonials: content, author_role ────────────────────────────
        $this->convertToJson('testimonials', ['content', 'author_role']);
    }

    public function down(): void
    {
        $this->revertFromJson('properties', ['title', 'description']);
        $this->revertFromJson('blog_posts', ['title', 'excerpt', 'content']);
        $this->revertFromJson('services', ['title', 'description']);
        $this->revertFromJson('team_members', ['role', 'bio']);
        $this->revertFromJson('testimonials', ['content', 'author_role']);
    }

    /** Convert string/text columns to JSON-encoded locale map {"en": "..."} */
    private function convertToJson(string $table, array $columns): void
    {
        Schema::table($table, function (Blueprint $t) use ($columns) {
            foreach ($columns as $col) {
                $t->json("{$col}_tmp")->nullable();
            }
        });

        DB::table($table)->orderBy('id')->each(function ($row) use ($table, $columns) {
            $update = [];
            foreach ($columns as $col) {
                $val = $row->$col;
                $update["{$col}_tmp"] = $val !== null ? json_encode(['en' => $val]) : null;
            }
            DB::table($table)->where('id', $row->id)->update($update);
        });

        Schema::table($table, function (Blueprint $t) use ($columns) {
            $t->dropColumn($columns);
        });

        Schema::table($table, function (Blueprint $t) use ($columns) {
            foreach ($columns as $col) {
                $t->renameColumn("{$col}_tmp", $col);
            }
        });
    }

    /** Reverse: extract EN value back to plain string/text */
    private function revertFromJson(string $table, array $columns): void
    {
        Schema::table($table, function (Blueprint $t) use ($columns) {
            foreach ($columns as $col) {
                $t->text("{$col}_rev")->nullable();
            }
        });

        DB::table($table)->orderBy('id')->each(function ($row) use ($table, $columns) {
            $update = [];
            foreach ($columns as $col) {
                $decoded = $row->$col ? json_decode($row->$col, true) : null;
                $update["{$col}_rev"] = is_array($decoded) ? ($decoded['en'] ?? null) : $decoded;
            }
            DB::table($table)->where('id', $row->id)->update($update);
        });

        Schema::table($table, function (Blueprint $t) use ($columns) {
            $t->dropColumn($columns);
        });

        Schema::table($table, function (Blueprint $t) use ($columns) {
            foreach ($columns as $col) {
                $t->renameColumn("{$col}_rev", $col);
            }
        });
    }
};
