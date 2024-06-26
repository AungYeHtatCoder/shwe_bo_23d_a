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
        Schema::create('lottery_two_digit_pivot', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lottery_id');
        $table->unsignedBigInteger('twod_game_result_id')->nullable();
        $table->string('bet_digit');
        // sub amount
        $table->integer('sub_amount')->default(0);
        //prize_sent 
        $table->boolean('prize_sent')->default(false);
        $table->string('match_status');
        $table->date('res_date');
        $table->time('res_time');
        $table->enum('session', ['morning', 'evening']); // Game session (morning or evening)
        $table->foreign('twod_game_result_id')->references('id')->on('twod_game_results')->onDelete('cascade');
        $table->foreign('lottery_id')->references('id')->on('lotteries')->onDelete('cascade');
        //$table->foreign('two_digit_id')->references('id')->on('two_digits')->onDelete('cascade');
        $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_two_digit_pivot');
    }
};