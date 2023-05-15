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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('position_id')->default(0);
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('phone');
            $table->string('external_phone')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('salary')->default(0);
            $table->string('coupon')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('note')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('is_online')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
