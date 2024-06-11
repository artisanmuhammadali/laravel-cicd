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
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('banner')->nullable();
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
