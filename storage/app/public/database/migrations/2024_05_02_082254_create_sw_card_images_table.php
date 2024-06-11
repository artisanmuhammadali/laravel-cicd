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
        Schema::create('sw_card_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sw_card_id')->references('id')->on('sw_cards')->onDelete('cascade');
            $table->string('url')->nullable();
            $table->text('type')->nullable();
            $table->integer('is_shifted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_card_images');
    }
};
