<?php

use App\Support\DbTableHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('temp_files')) {
            Schema::create('temp_files', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('item_type');
                DbTableHelper::morphUserColumn($table);
                $table->string('file_name');
                $table->string('original_name');
                $table->string('dir_name');
                $table->string('path');
                $table->unsignedBigInteger('file_size');
                $table->string('extension');
                $table->string('mime_type');
                $table->unsignedInteger('server_id')->default(0);
                $table->unsignedInteger('width')->default(0);
                $table->unsignedInteger('height')->default(0);
                $table->string('thumbnail_sizes')->nullable();
                $table->string('square_thumbnail_sizes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('core_attachments')) {
            Schema::create('core_attachments', function (Blueprint $table) {
                $table->bigIncrements('id');
                DbTableHelper::morphUserColumn($table);
                DbTableHelper::morphNullableItemColumn($table);
                $table->string('file_name');
                $table->string('original_name');
                $table->string('dir_name');
                $table->string('path');
                $table->unsignedBigInteger('file_size');
                $table->string('extension');
                $table->string('mime_type');
                $table->unsignedInteger('server_id')->default(0);
                $table->unsignedInteger('width')->default(0);
                $table->unsignedInteger('height')->default(0);
                $table->unsignedTinyInteger('is_image')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('core_attachment_file_types')) {
            Schema::create('core_attachment_file_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('extension');
                $table->string('mime_type');
                $table->unsignedTinyInteger('is_active')->default(1);
            });
        }

        if (!Schema::hasTable('core_timezones')) {
            Schema::create('core_timezones', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('offset', 10);
                $table->string('diff_from_gtm');
                $table->unsignedTinyInteger('is_active')->default(1);
            });
        }

        if (!Schema::hasTable('core_storage_services')) {
            Schema::create('core_storage_services', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('driver');
                $table->string('name');
                $table->string('service_class');
            });
        }

        if (!Schema::hasTable('core_storage')) {
            Schema::create('core_storage', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('server_id')->index();
                $table->unsignedInteger('service_id')->index();
                $table->unsignedTinyInteger('is_default')->default(0);
                $table->unsignedTinyInteger('is_active')->default(0);
                $table->string('name');
                $table->text('config')->nullable();

                $table->timestamps();
            });
        }

        if (!Schema::hasTable('core_countries')) {
            Schema::create('core_countries', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->char('country_iso', 2)->unique();

                $table->char('code', 2)->nullable();
                $table->char('code3', 3)->nullable();

                $table->char('numeric_code', 3)->nullable();
                $table->bigInteger('geonames_code')->nullable();
                $table->char('fips_code', 10)->nullable();

                $table->char('area', 10)->nullable();
                $table->char('currency', 5)->nullable();
                $table->string('phone_prefix')->nullable();
                $table->string('mobile_format')->nullable();
                $table->string('landline_format')->nullable();
                $table->string('trunk_prefix')->nullable();
                $table->bigInteger('population')->nullable();
                $table->char('continent', 10)->nullable();
                $table->char('language', 10)->nullable();

                $table->string('name')->index();

                $table->unsignedSmallInteger('ordering')->default(0);
                $table->unsignedTinyInteger('is_active')->default(1);
            });
        }

        if (!Schema::hasTable('core_country_states')) {
            Schema::create('core_country_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('country_iso', 2)->index();
                $table->string('state_iso', 10)->index();

                $table->bigInteger('state_code')->index();

                $table->bigInteger('geonames_code')->nullable();
                $table->string('fips_code', 10)->nullable();
                $table->text('post_codes')->nullable();
                $table->string('timezone')->nullable();

                $table->string('name')->index();
                $table->unsignedSmallInteger('ordering')->default(0);
            });
        }

        if (!Schema::hasTable('core_country_cities')) {
            Schema::create('core_country_cities', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('state_code')->index();
                $table->bigInteger('city_code')->index();

                $table->bigInteger('geonames_code')->nullable();

                $table->decimal('latitude', 30, 2)->nullable();
                $table->decimal('longitude', 30, 2)->nullable();
                $table->string('capital')->nullable();

                $table->bigInteger('population')->nullable();

                $table->string('name')->index();
                $table->unsignedSmallInteger('ordering')->default(0);
            });
        }

        if (!Schema::hasTable('core_currency')) {
            Schema::create('core_currency', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->char('code', 3)->unique();
                $table->char('symbol', 15);
                $table->string('name');
                $table->string('format')->default('{0} #,###.00 {1}');
                $table->unsignedTinyInteger('is_default')->default(0);
                $table->unsignedTinyInteger('is_active')->default(0);
                $table->unsignedSmallInteger('ordering')->default(0);
            });
        }

        if (!Schema::hasTable('core_languages')) {
            Schema::create('core_languages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('language_code');
                $table->string('charset')->default('utf-8');
                $table->string('direction')->default('ltr');
                $table->smallInteger('is_default')->default(0);
                $table->smallInteger('is_active')->default(1);
                $table->smallInteger('is_master')->default(0);
                $table->string('version')->default('5.0.1');
                $table->integer('store_id')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_files');
        Schema::dropIfExists('core_attachment_file_types');
        Schema::dropIfExists('core_timezones');
        Schema::dropIfExists('core_storage_services');
        Schema::dropIfExists('core_storage');
        Schema::dropIfExists('core_countries');
        Schema::dropIfExists('core_country_states');
        Schema::dropIfExists('core_country_cities');
        Schema::dropIfExists('core_currency');
        Schema::dropIfExists('core_languages');
    }
};
