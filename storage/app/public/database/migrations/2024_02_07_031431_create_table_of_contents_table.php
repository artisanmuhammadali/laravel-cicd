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
        Schema::create('table_of_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->references('id')->on('pages')->constrained()->onDelete('cascade');
            $table->string('content')->nullable();
            $table->string('link')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_of_contents');
    }
};
