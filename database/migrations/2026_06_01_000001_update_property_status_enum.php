<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement(<<<'SQL'
                CREATE TABLE "properties_new" (
                    "id" integer primary key autoincrement not null,
                    "slug" varchar not null,
                    "address" varchar not null,
                    "city" varchar not null,
                    "state_country" varchar not null,
                    "postal_code" varchar not null,
                    "price" numeric not null,
                    "currency" varchar not null default 'EUR',
                    "property_type" varchar check ("property_type" in ('flat','studio','house','duplex','penthouse','bungalow','other')) not null,
                    "status" varchar check ("status" in ('for_sale','for_rent','sold','rented','new')) not null default 'for_sale',
                    "bedrooms" integer not null default '0',
                    "bathrooms" integer not null default '0',
                    "sqm" numeric not null default '0',
                    "images" text,
                    "is_featured" tinyint(1) not null default '0',
                    "property_id_ref" varchar,
                    "created_at" datetime,
                    "updated_at" datetime,
                    "title" text,
                    "description" text,
                    "meta_title" text,
                    "meta_description" text,
                    "source" varchar,
                    "external_id" varchar,
                    "province" varchar,
                    "living_area" numeric not null default '0',
                    "original_price" numeric,
                    "latitude" numeric,
                    "longitude" numeric,
                    "extra_data" text,
                    "source_synced_at" datetime
                )
            SQL);

            DB::statement(<<<'SQL'
                INSERT INTO "properties_new"
                SELECT
                    "id", "slug", "address", "city", "state_country", "postal_code",
                    "price", "currency", "property_type", "status", "bedrooms", "bathrooms",
                    "sqm", "images", "is_featured", "property_id_ref", "created_at", "updated_at",
                    "title", "description", "meta_title", "meta_description", "source",
                    "external_id", "province", "living_area", "original_price", "latitude",
                    "longitude", "extra_data", "source_synced_at"
                FROM "properties"
            SQL);

            DB::statement('DROP TABLE "properties"');
            DB::statement('ALTER TABLE "properties_new" RENAME TO "properties"');
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement("ALTER TABLE properties MODIFY COLUMN status ENUM('for_sale','for_rent','sold','rented','new') NOT NULL DEFAULT 'for_sale'");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement(<<<'SQL'
                CREATE TABLE "properties_new" (
                    "id" integer primary key autoincrement not null,
                    "slug" varchar not null,
                    "address" varchar not null,
                    "city" varchar not null,
                    "state_country" varchar not null,
                    "postal_code" varchar not null,
                    "price" numeric not null,
                    "currency" varchar not null default 'EUR',
                    "property_type" varchar check ("property_type" in ('flat','studio','house','duplex','penthouse','bungalow','other')) not null,
                    "status" varchar check ("status" in ('for_sale','for_rent','sold','rented')) not null default 'for_sale',
                    "bedrooms" integer not null default '0',
                    "bathrooms" integer not null default '0',
                    "sqm" numeric not null default '0',
                    "images" text,
                    "is_featured" tinyint(1) not null default '0',
                    "property_id_ref" varchar,
                    "created_at" datetime,
                    "updated_at" datetime,
                    "title" text,
                    "description" text,
                    "meta_title" text,
                    "meta_description" text,
                    "source" varchar,
                    "external_id" varchar,
                    "province" varchar,
                    "living_area" numeric not null default '0',
                    "original_price" numeric,
                    "latitude" numeric,
                    "longitude" numeric,
                    "extra_data" text,
                    "source_synced_at" datetime
                )
            SQL);

            DB::statement(<<<'SQL'
                INSERT INTO "properties_new"
                SELECT
                    "id", "slug", "address", "city", "state_country", "postal_code",
                    "price", "currency", "property_type",
                    CASE WHEN "status" = 'new' THEN 'for_sale' ELSE "status" END,
                    "bedrooms", "bathrooms", "sqm", "images", "is_featured", "property_id_ref",
                    "created_at", "updated_at", "title", "description", "meta_title",
                    "meta_description", "source", "external_id", "province", "living_area",
                    "original_price", "latitude", "longitude", "extra_data", "source_synced_at"
                FROM "properties"
            SQL);

            DB::statement('DROP TABLE "properties"');
            DB::statement('ALTER TABLE "properties_new" RENAME TO "properties"');
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement("UPDATE properties SET status = 'for_sale' WHERE status = 'new'");
            DB::statement("ALTER TABLE properties MODIFY COLUMN status ENUM('for_sale','for_rent','sold','rented') NOT NULL DEFAULT 'for_sale'");
        }
    }
};
