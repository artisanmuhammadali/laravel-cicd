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
            $table->string('released_date')->nullable();
        });
        
        \DB::table('mtg_sets')->update([
            'released_date' => \DB::raw('released_at')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_sets', function (Blueprint $table) {
            $table->dropColumn(['released_date']);
        });
    }
};
