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
        Schema::create('sw_user_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sw_card_id')->references('id')->on('sw_cards')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('card_type', ['single', 'sealed', 'completed'])->default('single');
            $table->string('language');
            $table->string('condition');
            $table->integer('cost')->nullable();
            $table->integer('hp')->nullable();
            $table->integer('power')->nullable();
            $table->string('price');
            $table->string('quantity');
            $table->boolean('foil')->default(0);
            $table->boolean('signed')->default(0);
            $table->boolean('altered')->default(0);
            $table->boolean('graded')->default(0);
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->boolean('publish')->default(0);
            $table->integer('int_collector_number')->default(0);
            $table->string('cmc')->nullable();
            $table->string('name')->nullable();
            $table->string('sub_title')->nullable();
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
            $table->string('hyprspace')->nullable();
            $table->string('showcase')->nullable();
            $table->string('rarity')->nullable();
            $table->string('type')->nullable();
            $table->string('type2')->nullable();
            $table->string('set_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_user_collections');
    }
};
