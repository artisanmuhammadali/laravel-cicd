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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recieve_by')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('send_by')->nullable()->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->enum('type',['order','message']);
            $table->string('message')->nullable();
            $table->integer('model_id')->nullable();
            $table->boolean('is_readed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
