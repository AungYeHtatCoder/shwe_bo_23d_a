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
        Schema::create('lotto_three_digit_copy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('three_digit_id');
            $table->unsignedBigInteger('lotto_id');
            //$table->string('digit_entry', 3); 
            $table->integer('sub_amount')->default(0);
            $table->boolean('prize_sent')->default(false);
            // $table->foreign('three_digit_id')->references('id')->on('three_digits')->onDelete('cascade');
            $table->foreign('lotto_id')->references('id')->on('lottos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotto_three_digit_copy');
    }
};
