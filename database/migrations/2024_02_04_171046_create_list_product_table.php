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
        Schema::create('list_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idStore');
            $table->foreignId('idProduct');
            $table->integer('quantity');
            $table->integer('idSize');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_product');
    }
};
