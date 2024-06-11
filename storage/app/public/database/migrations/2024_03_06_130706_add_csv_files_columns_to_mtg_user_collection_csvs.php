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
            $table->string('wrong_file')->nullable()->after('success');
            $table->string('success_file')->nullable()->after('success');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtg_user_collection_csvs', function (Blueprint $table) {
            $table->dropColumn('wrong_file');
            $table->dropColumn('success_file');
        });
    }
};
