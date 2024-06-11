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
        Schema::create('card_market_data', function (Blueprint $table) {
            $table->id();
            $table->string('card_market_id')->nullable();
            $table->string('name')->nullable();
            $table->string('set_name')->nullable();
            $table->string('set_code')->nullable();
            $table->string('scryfall_id')->nullable();
            $table->string('tcgplayer_id')->nullable();
            $table->string('collector_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_market_data');
    }
};
