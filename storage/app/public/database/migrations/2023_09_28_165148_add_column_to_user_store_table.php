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
        Schema::table('user_stores', function (Blueprint $table) {
            $table->string('company_trade_licence')->nullable();
            $table->string('newsletter')->nullable();
            $table->string('policy');
            $table->string('hear_about_us');
            $table->string('terms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_stores', function (Blueprint $table) {
            //
        });
    }
};
