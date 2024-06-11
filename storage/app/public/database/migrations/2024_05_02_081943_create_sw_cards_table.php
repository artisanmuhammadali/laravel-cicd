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
        Schema::create('sw_cards', function (Blueprint $table) {
            $table->id();
            $table->string('sw_set_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('sw_card_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_uid')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('artist')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('foil')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('hp')->nullable();
            $table->integer('power')->nullable();
            $table->text('text')->nullable();
            $table->text('styled_text')->nullable();
            $table->text('keywords')->nullable();
            $table->text('aspects')->nullable();
            $table->text('arenas')->nullable();
            $table->text('traits')->nullable();
            $table->integer('weight')->default(2);
            $table->text('epic_action')->nullable();
            $table->text('styled_epic_action')->nullable();
            $table->text('deploy_box')->nullable();
            $table->text('styled_deploy_box')->nullable();
            $table->string('sw_created_at')->nullable();
            $table->string('sw_updated_at')->nullable();
            $table->string('sw_published_at')->nullable();
            $table->string('published_at')->nullable();
            $table->string('unique')->nullable();
            $table->string('hyperspace')->nullable();
            $table->string('showcase')->nullable();
            $table->string('rarity')->nullable();
            $table->string('card_type')->default('single');
            $table->string('type')->nullable();
            $table->string('type2')->nullable();
            $table->string('set_code')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_cards');
    }
};
