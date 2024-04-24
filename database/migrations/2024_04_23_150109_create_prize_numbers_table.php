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
        Schema::create('prize_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('three_d_prize_id');
            $table->string('number'); // Prize number
            $table->timestamps();
             $table->foreign('three_d_prize_id')->references('id')->on('three_d_prizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prize_numbers');
    }
};