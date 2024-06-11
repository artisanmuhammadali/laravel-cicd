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
        Schema::create('order_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->references('id')->on('orders')->constrained()->onDelete('cascade');
            $table->foreignId('review_by')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('review_to')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->float('rating')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_reviews');
    }
};
