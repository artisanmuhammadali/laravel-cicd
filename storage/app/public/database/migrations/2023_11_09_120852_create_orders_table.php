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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('remarks')->nullable();
            $table->string('total');
            $table->longText('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
