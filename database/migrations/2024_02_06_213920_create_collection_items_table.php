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
        Schema::create('collection_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCollection');
            $table->string('path');
            $table->string('title');
            $table->timestamps();

            $table->foreign('idCollection')->references('id')->on('collections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_items');
    }
};
