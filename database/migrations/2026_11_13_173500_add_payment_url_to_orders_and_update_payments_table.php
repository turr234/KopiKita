<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'payment_url')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('payment_url')->nullable()->after('payment_method');
            });
        }

        if (Schema::hasTable('payments')) {
            try {
                DB::statement("ALTER TABLE payments MODIFY COLUMN method VARCHAR(50) DEFAULT 'bank_transfer'");
            } catch (\Throwable $e) {
                // If already modified or fails, continue
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'payment_url')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_url');
            });
        }
    }
};
