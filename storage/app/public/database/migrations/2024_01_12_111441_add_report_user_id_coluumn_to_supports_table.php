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
        Schema::table('supports', function (Blueprint $table) {
            $table->foreignId('report_to_id')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('report_by_id')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supports', function (Blueprint $table) {
        });
    }
};
