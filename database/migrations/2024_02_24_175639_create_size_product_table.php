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
        Schema::create('size_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idSize');
            $table->unsignedBigInteger('idProduct');
            $table->timestamp('create_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent();
            
            $table->foreign('idProduct')->references('id')->on('products');
            $table->foreign('idSize')->references('id')->on('sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_product');
    }
};
