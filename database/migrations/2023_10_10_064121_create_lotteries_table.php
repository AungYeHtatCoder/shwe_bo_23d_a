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
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->integer('pay_amount')->default(0);
            $table->integer('total_amount')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lottery_match_id')->default(1);
            //$table->enum('session', ['morning', 'evening']); 
            $table->decimal('comission', 8, 2)->default(0);
            $table->decimal('commission_amount', 8, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lottery_match_id')->references('id')->on('lottery_matches')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotteries');
    }
};