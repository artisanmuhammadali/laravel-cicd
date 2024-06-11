<?php

use App\Models\MTG\MtgCustomSetType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mtg_custom_set_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });


        MtgCustomSetType::create(['name' => 'Art Cards', 'slug' => 'art-cards']);
        MtgCustomSetType::create(['name' => 'Tokens', 'slug' => 'tokens']);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtg_custom_set_types');
    }
};
