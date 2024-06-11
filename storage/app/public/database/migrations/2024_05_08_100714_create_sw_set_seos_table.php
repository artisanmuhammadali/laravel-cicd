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
        Schema::create('sw_set_seos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sw_set_id')->references('id')->on('sw_sets')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('type',['single','sealed','completed'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_set_seos');
    }
};
