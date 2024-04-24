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
        Schema::create('three_d_prizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('three_d_game_id'); // Foreign key to ThreeDGame
            $table->string('name'); // Prize name
            $table->string('reward'); // Reward amount
            $table->integer('amount'); // Number of winners
            $table->timestamps();
           $table->foreign('three_d_game_id')->references('id')->on('three_d_games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('three_d_prizes');
    }
};