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
        Schema::create('mtg_sets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('set_type')->nullable();
            $table->string('card_count')->nullable();
            $table->string('parent_set_code')->nullable();
            $table->text('icon')->nullable();
            $table->string('type')->default('expansion');
            $table->string('released_at')->nullable();
            $table->timestamp('cards_updated_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_sets');
    }
};
