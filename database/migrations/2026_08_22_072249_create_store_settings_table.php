<?php

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
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('store_name', 150);
            $table->string('tagline', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->string('address')->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('tiktok_url', 255)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('about')->nullable();
            $table->unsignedInteger('minimum_stock_warning')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
