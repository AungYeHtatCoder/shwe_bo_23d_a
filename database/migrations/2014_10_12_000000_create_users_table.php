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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable()->unique();
            $table->string('username')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('register_type')->nullable();
            $table->string('third_party_id')->nullable();
            $table->string('token')->nullable();
            $table->string('device_id')->nullable();
            $table->string('fcm_token')->nullable();
            $table->integer('status')->default(0);
            //$table->string('role')->nullable();
            $table->integer('gem')->default('0');
            $table->integer('bonus')->default('0');
            $table->integer('limit')->default('500');
            $table->integer('limit3')->default('500');
            $table->integer('cor')->default('5');
            $table->integer('cor3')->default('5');
            $table->integer('zero')->default('0');
            $table->string('remark', 150)->nullable();
            $table->string('chk', 100)->nullable();
            $table->string('photo', 5)->default('0');
            $table->string('photo_mime')->nullable();
            $table->integer('photo_size')->nullable();
            $table->string('language', 2)->default('my');
            $table->dateTime('active')->nullable();
            $table->string('kpay_no')->nullable()->default('N/A');
            $table->string('cbpay_no')->nullable()->default('N/A');
            $table->string('wavepay_no')->nullable()->default('N/A');
            $table->string('ayapay_no')->nullable()->default('N/A');
            $table->integer('balance')->default(500000);
            $table->integer('prize_balance')->nullable()->default('0');
            //$table->integer('status')->default(0);
            //$table->unsignedBigInteger('agent_id')->default(1);
            $table->rememberToken();
            $table->timestamps();
           // $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};