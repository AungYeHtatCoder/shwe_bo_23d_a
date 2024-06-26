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
        Schema::create('result_dates', function (Blueprint $table) {
            $table->id();
            $table->date('result_date'); // Date of the lottery result
            $table->time('result_time'); // Time of the lottery result
            $table->string('result_number')->nullable();
            $table->enum('status', ['open', 'closed', 'pending'])->default('pending'); // Status of the lottery
            $table->enum('admin_log', ['open', 'closed'])->default('open'); // New status column
            $table->enum('user_log', ['open', 'closed'])->default('open'); // New status column
            $table->string('endpoint')->nullable(); // Endpoint URL for more information
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_dates');
    }
};