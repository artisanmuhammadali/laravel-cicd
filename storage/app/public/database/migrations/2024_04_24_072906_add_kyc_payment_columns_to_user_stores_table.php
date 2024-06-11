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
            $table->float('kyc_amount')->default(0.00)->after('return_kyc_payment');
            $table->float('kyc_refunded_amount')->default(0.00)->after('return_kyc_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_stores', function (Blueprint $table) {
            $table->dropColumn('kyc_amount');
            $table->dropColumn('kyc_refunded_amount');
        });
    }
};
