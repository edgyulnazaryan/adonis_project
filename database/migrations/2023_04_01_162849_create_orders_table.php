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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_number');
            $table->bigInteger('product_id');
            $table->bigInteger('user_id');
            $table->tinyInteger('status')->default(0);
            $table->integer('quantity')->default(1);
            $table->integer('price')->default(0);
            $table->json('delivery_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
