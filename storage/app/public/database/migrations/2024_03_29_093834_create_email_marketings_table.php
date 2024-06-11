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
        Schema::create('email_marketings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sent_by')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('newsletter')->nullable();
            $table->string('status')->nullable();
            $table->string('referal_type')->nullable();
            $table->string('role')->nullable();
            $table->string('unverified')->nullable();
            $table->longText('subject');
            $table->longText('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_marketings');
    }
};
