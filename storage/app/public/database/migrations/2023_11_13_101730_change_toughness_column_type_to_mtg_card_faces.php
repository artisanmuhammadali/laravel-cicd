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
        Schema::table('mtg_card_faces', function (Blueprint $table) {
            $table->integer('toughness')->change();
            $table->integer('power')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_card_faces', function (Blueprint $table) {
            $table->string('toughness')->change();
            $table->string('power')->change();
        });
    }
};
