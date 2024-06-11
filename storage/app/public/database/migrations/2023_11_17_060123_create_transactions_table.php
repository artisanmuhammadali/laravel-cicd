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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_user')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('debit_user')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
            $table->string('transaction_id')->nullable();
            $table->enum('type',['payin','payout','refund','credit','debit','referal'])->nullable();
            $table->float('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
