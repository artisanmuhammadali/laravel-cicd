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
        Schema::table('mtg_sets', function (Blueprint $table) {
            $table->boolean('foil')->default(false);
            $table->boolean('nonfoil')->default(false);
            $table->longText('languages')->nullable();
            $table->longText('legalities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_sets', function (Blueprint $table) {
            //
        });
    }
};
