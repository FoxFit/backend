<?php

use App\Support\DbTableHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();

            $table->string('phone_number')->nullable();
            $table->string('full_phone_number')->nullable();

            $table->tinyInteger('gender')->default(0);

            $table->date('birthday')->nullable();
            $table->string('birthday_search')->nullable();
            $table->unsignedInteger('birthday_doy')->nullable();
            $table->string('country_iso')->nullable();
            $table->string('country_state_id')->default(0);
            $table->string('country_city_code')->default(0);
            $table->string('city_location')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('language_id')->nullable();
            $table->unsignedInteger('timezone_id')->default(0);
            $table->string('currency_id', 3)->nullable();
            $table->tinyInteger('dst_check')->default(0);

            DbTableHelper::morphImage($table, 'avatar');
            DbTableHelper::morphImage($table, 'cover');

            $table->string('status')->nullable();
            $table->unsignedBigInteger('invite_user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
