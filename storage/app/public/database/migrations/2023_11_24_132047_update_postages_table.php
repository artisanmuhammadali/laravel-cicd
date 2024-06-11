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
        Schema::table('postages', function (Blueprint $table) {
            $table->boolean('is_trackable')->default(true);
            $table->dropColumn('card_count');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postages', function (Blueprint $table) {
            $table->dropColumn('is_trackable')->default(true);
            $table->integer('card_count');
            $table->string('type');
        });
    }
};
