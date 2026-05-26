<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('is_translatable')->default(false)->after('type');
            $table->json('value_tmp')->nullable()->after('value');
        });

        DB::table('site_settings')->orderBy('id')->each(function ($row) {
            DB::table('site_settings')->where('id', $row->id)->update([
                'value_tmp' => $row->value !== null ? json_encode(['en' => $row->value]) : null,
            ]);
        });

        // Mark prose settings as translatable
        DB::table('site_settings')
            ->whereIn('key', ['site_description', 'footer_about'])
            ->update(['is_translatable' => true]);

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->renameColumn('value_tmp', 'value');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('value_rev')->nullable()->after('value');
        });

        DB::table('site_settings')->orderBy('id')->each(function ($row) {
            $decoded = $row->value ? json_decode($row->value, true) : null;
            DB::table('site_settings')->where('id', $row->id)->update([
                'value_rev' => is_array($decoded) ? ($decoded['en'] ?? null) : $decoded,
            ]);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['value', 'is_translatable']);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->renameColumn('value_rev', 'value');
        });
    }
};
