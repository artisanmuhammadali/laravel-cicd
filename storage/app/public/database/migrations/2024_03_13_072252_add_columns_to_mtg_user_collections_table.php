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
        Schema::table('mtg_user_collections', function (Blueprint $table) {
            $table->string('rarity')->nullable();
            $table->integer('int_collector_number')->default(0);
            $table->string('cmc')->nullable();
            $table->string('card_name')->nullable();
            $table->date('released_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_user_collections', function (Blueprint $table) {
            $table->dropColumns(['rarity','int_collector_number','cmc','card_name','released_at']);
        });
    }
};
