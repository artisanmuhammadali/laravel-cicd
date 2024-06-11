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
        Schema::create('mtg_user_collection_csvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('file')->nullable();
            $table->string('header')->nullable();
            $table->boolean('imported')->default(0);
            $table->enum('mtg_card_type',['single','sealed','completed'])->default('single');
            $table->enum('status',['processing','done'])->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_user_collection_csvs');
    }
};
