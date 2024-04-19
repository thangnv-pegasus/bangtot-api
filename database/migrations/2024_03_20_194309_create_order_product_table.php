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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idOrder');
            $table->unsignedBigInteger('idProduct');
            $table->integer('quantity');
            $table->unsignedBigInteger('idSize');
            $table->timestamps();

            $table->foreign('idOrder')->references('id')->on('order');
            // $table->foreign('idOrder')->references('id')->on('order_guest');
            $table->foreign('idProduct')->references('id')->on('products');
            $table->foreign('idSize')->references('id')->on('sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
