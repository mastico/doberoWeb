<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['properties', 'blog_posts', 'services'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->json('meta_title')->nullable();
                $table->json('meta_description')->nullable();
            });
        }

        Schema::create('faq_items', function (Blueprint $table): void {
            $table->id();
            $table->string('page');
            $table->json('question');
            $table->json('answer');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['page', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_items');

        foreach (['properties', 'blog_posts', 'services'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn(['meta_title', 'meta_description']);
            });
        }
    }
};

