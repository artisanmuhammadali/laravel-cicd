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
        Schema::create('mtg_card_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mtg_card_id')->nullable()->references('id')->on('mtg_cards')->onDelete('cascade');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_card_languages');
    }
};
