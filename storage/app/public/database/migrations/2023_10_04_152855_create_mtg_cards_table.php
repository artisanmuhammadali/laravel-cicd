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
        Schema::create('mtg_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_id')->nullable();
            $table->string('oracle_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('set_code')->nullable();
            $table->string('collector_number')->nullable();
            $table->date('released_at')->nullable();
            $table->string('layout')->nullable();
            $table->string('cmc')->nullable();
            $table->text('legalities')->nullable();
            $table->boolean('foil')->default(false);
            $table->boolean('nonfoil')->default(false);
            $table->text('finishes')->nullable();
            $table->boolean('oversized')->default(false);
            $table->string('rarity')->nullable();
            $table->string('frame')->nullable();
            $table->text('frame_effects')->nullable();
            $table->text('promo_types')->nullable();
            $table->text('languages')->nullable();
            $table->boolean('is_card_faced')->default(false);
            $table->enum('card_type', ['single', 'sealed', 'completed'])->default('single');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_cards');
    }
};
