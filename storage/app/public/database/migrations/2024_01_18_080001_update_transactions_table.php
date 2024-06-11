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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type',['payin','payout','refund','credit','debit','referal','order-transfer','cancelled','extra'])->nullable()->change();
            $table->float('seller_amount')->default(0)->after('amount');
            $table->float('fee')->default(0)->after('amount');
            $table->float('expenses')->default(0)->after('amount');
            $table->float('shiping_charges')->default(0)->after('amount');
            $table->foreignId('parent_id')->nullable()->references('id')->on('transactions')->constrained()->onDelete('set null')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type',['payin','payout','refund','credit','debit','referal','fee'])->nullable()->change();
            $table->dropColumn('seller_amount');
            $table->dropColumn('fee');
            $table->dropColumn('expenses');
            $table->dropColumn('shiping_charges');
            $table->dropColumn('parent_id');
        });
    }
};
