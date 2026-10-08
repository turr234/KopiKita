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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 150)->index();
            $table->string('slug', 180)->unique();
            $table->string('sku', 50)->unique();
            $table->longText('description')->nullable()->default(null);
            $table->string('origin', 100)->nullable()->default(null);
            $table->string('tasting_notes', 255)->nullable()->default(null);
            $table->decimal('price', 15,2)->index()->default(0);
            $table->decimal('discount_price', 15,2)->nullable()->default(null);
            $table->unsignedInteger('stock')->default(0)->index();
            $table->unsignedInteger('weight')->default(0);
            $table->string('main_image', 255)->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sold_count')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
