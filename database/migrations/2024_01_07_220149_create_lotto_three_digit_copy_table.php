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
            $table->unsignedBigInteger('result_date_id')->nullable();
            $table->unsignedBigInteger('lotto_id');
            $table->string('bet_digit');
            $table->integer('sub_amount')->default(0);
            $table->boolean('prize_sent')->default(false);
            $table->string('match_status');
            $table->date('res_date');
            $table->string('result_number')->nullable();
            $table->enum('admin_log', ['open', 'closed'])->default('open');
            $table->enum('user_log', ['open', 'closed'])->default('open');
            $table->foreign('result_date_id')->references('id')->on('result_dates')->onDelete('cascade');
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