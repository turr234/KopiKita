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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('set null');
            $table->string('payment_code', 50)->unique();
            $table->enum('method', ['bank_transfer'])->default('bank_transfer');
            $table->string('sender_name', 100)->nullable();
            $table->string('sender_bank', 100)->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('proof_image', 255)->nullable();
            $table->enum('status', ['pending', 'paid', 'rejected', 'refunded'])->default('pending')->index();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
