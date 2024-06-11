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
        Schema::create('mtg_card_faces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mtg_card_id')->nullable()->references('id')->on('mtg_cards')->onDelete('cascade');
            $table->string('mana_cost')->nullable();
            $table->longText('oracle_text')->nullable();
            $table->string('type_line')->nullable();
            $table->string('power')->nullable();
            $table->string('toughness')->nullable();
            $table->string('artist')->nullable();
            $table->text('colors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_card_faces');
    }
};
