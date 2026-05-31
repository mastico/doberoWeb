<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->string('source')->nullable()->after('property_id_ref');
            $table->string('external_id')->nullable()->after('source');
            $table->string('province')->nullable()->after('external_id');
            $table->decimal('living_area', 12, 2)->default(0)->after('sqm');
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
            $table->decimal('latitude', 10, 7)->nullable()->after('province');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->json('extra_data')->nullable()->after('longitude');
            $table->timestamp('source_synced_at')->nullable()->after('extra_data');
        });

        Schema::table('properties', function (Blueprint $table): void {
            $table->unique(['source', 'external_id'], 'properties_source_external_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->dropUnique('properties_source_external_id_unique');
            $table->dropColumn([
                'source',
                'external_id',
                'province',
                'living_area',
                'original_price',
                'latitude',
                'longitude',
                'extra_data',
                'source_synced_at',
            ]);
        });
    }
};
