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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('bank_transfer')->change();
            $table->string('status', 50)->default('pending')->change();
            $table->string('payment_status', 50)->default('unpaid')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('bank_transfer')->change();
            $table->string('status', 50)->default('waiting_payment')->change();
            $table->string('payment_status', 50)->default('unpaid')->change();
        });
    }
};
