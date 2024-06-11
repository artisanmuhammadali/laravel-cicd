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
        Schema::create('user_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mtg_card_id')->references('id')->on('mtg_cards')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('mtg_card_type', ['single', 'sealed', 'completed'])->default('single');
            $table->string('language');
            $table->string('condition');
            $table->string('price');
            $table->string('quantity');
            $table->boolean('foil')->default(0);
            $table->boolean('signed')->default(0);
            $table->boolean('altered')->default(0);
            $table->boolean('graded')->default(0);
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_collections');
    }
};
