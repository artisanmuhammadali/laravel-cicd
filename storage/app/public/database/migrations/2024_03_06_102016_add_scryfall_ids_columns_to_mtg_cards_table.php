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
        Schema::table('mtg_cards', function (Blueprint $table) {
            $table->string('tcgplayer_id')->nullable()->after('card_id');
            $table->string('cardmarket_id')->nullable()->after('card_id');
            $table->string('mtgo_id')->nullable()->after('card_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_cards', function (Blueprint $table) {
            $table->dropColumn('tcgplayer_id');
            $table->dropColumn('cardmarket_id');
            $table->dropColumn('mtgo_id');
        });
    }
};
