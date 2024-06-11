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
            $table->dropColumn('address');
            $table->dropColumn('street_number');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('company_trade_licence');
            $table->string('registration_proof')->nullable()->after('name');
            $table->string('article_of_association')->nullable()->after('name');
            $table->string('company_name')->nullable()->after('name');
            $table->string('company_no')->nullable()->after('name');
            $table->string('mangopay_wallet_id')->nullable()->after('mango_id');
            $table->string('mangopay_account_id')->nullable()->after('mango_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
