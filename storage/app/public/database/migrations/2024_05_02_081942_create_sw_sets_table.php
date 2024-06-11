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
        Schema::create('sw_sets', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('custom_type')->default('singles');
            $table->string('sw_created_at')->nullable();
            $table->string('sw_updated_at')->nullable();
            $table->string('sw_published_at')->nullable();
            $table->string('published_at')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_sets');
    }
};
