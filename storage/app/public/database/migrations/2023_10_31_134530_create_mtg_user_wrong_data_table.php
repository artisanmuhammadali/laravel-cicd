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
        Schema::create('mtg_user_wrong_data', function (Blueprint $table) {
            $table->id();
            $table->string('card_name')->nullable();
            $table->string('set_name')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('mtg_card_type', ['single', 'sealed', 'completed'])->default('single');
            $table->string('language')->nullable();
            $table->string('condition')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->boolean('foil')->default(0);
            $table->boolean('signed')->default(0);
            $table->boolean('altered')->default(0);
            $table->boolean('graded')->default(0);
            $table->string('note')->nullable();
            $table->string('collector_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_user_wrong_data');
    }
};
