<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->float('price_sale');
            $table->unsignedBigInteger('collection_id');
            $table->longText('description')->default('description');
            $table->longText('detail')->default('detail');
            $table->timestamp('create_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent();

            $table->foreign('collection_id')->references('id')->on('collections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};