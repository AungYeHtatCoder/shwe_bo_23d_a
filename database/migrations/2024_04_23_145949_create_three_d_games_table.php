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
        Schema::create('three_d_games', function (Blueprint $table) {
            $table->id();
            $table->date('result_date'); // Result date
            $table->time('result_time'); // Result time
            $table->string('status')->default('closed'); // Default status
            $table->string('endpoint'); // Endpoint URL for results
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('three_d_games');
    }
};