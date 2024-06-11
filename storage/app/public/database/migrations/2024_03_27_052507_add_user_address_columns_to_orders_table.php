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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('country')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('address');
            $table->string('city')->nullable()->after('address');
            $table->string('street_address')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('postal_code');
            $table->dropColumn('city');
            $table->dropColumn('street_address');
        });
    }
};
