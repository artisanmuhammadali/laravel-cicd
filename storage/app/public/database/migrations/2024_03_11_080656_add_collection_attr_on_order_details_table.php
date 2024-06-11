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
            $table->integer('collection_id')->nullable();
            $table->string('language');
            $table->string('condition');
            $table->boolean('foil')->default(0);
            $table->boolean('signed')->default(0);
            $table->boolean('altered')->default(0);
            $table->boolean('graded')->default(0);
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->decimal('collection_price',12,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('collection_id');
            $table->dropColumn('language');
            $table->dropColumn('condition');
            $table->dropColumn('foil');
            $table->dropColumn('signed');
            $table->dropColumn('altered');
            $table->dropColumn('graded');
            $table->dropColumn('image');
            $table->dropColumn('note');
            $table->dropColumn('collection_price');
        });
    }
};
