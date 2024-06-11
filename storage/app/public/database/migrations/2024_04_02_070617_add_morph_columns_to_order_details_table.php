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
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('user_collection_id')->nullable()->after('mtg_user_collection_id');
            $table->string('user_collection_type')->nullable()->after('mtg_user_collection_id');
            $table->string('card_type')->nullable()->after('mtg_user_collection_id');
            $table->integer('card_id')->nullable()->after('mtg_user_collection_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('user_collection_id');
            $table->dropColumn('user_collection_type');
            $table->dropColumn('card_type');
            $table->dropColumn('card_id');
        });
    }
};
