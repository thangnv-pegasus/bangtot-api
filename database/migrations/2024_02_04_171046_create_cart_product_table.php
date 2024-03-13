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
        Schema::create('cart_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCart');
            $table->unsignedBigInteger('idProduct');
            $table->integer('quantity');
            $table->integer('idSize');
            $table->timestamps();
            
            $table->foreign('idProduct')->references('id')->on('products');
            $table->foreign('idCart')->references('id')->on('cart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
