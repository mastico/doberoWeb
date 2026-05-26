<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('state_country');
            $table->string('postal_code');
            $table->decimal('price', 12, 2);
            $table->string('currency')->default('EUR');
            $table->enum('property_type', ['house', 'flat', 'villa', 'apartment', 'commercial', 'land']);
            $table->enum('status', ['for_sale', 'for_rent', 'sold', 'rented'])->default('for_sale');
            $table->unsignedInteger('bedrooms')->default(0);
            $table->unsignedInteger('bathrooms')->default(0);
            $table->decimal('sqm', 8, 2)->default(0);
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('property_id_ref')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
