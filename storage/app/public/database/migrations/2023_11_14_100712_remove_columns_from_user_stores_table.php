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
            $table->dropColumn('terms');
            $table->dropColumn('policy');
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->float('referal_limit')->after('vfs_wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_stores', function (Blueprint $table) {
            $table->string('terms')->nullable();
            $table->string('policy')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
        });
    }
};
