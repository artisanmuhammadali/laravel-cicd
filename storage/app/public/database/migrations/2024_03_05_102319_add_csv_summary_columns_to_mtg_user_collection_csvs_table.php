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
        Schema::table('mtg_user_collection_csvs', function (Blueprint $table) {
            $table->integer('total')->default(0);
            $table->integer('success')->default(0);
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_user_collection_csvs', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('success');
        });
    }
};
