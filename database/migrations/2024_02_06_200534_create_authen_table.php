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
        Schema::create('authen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser');
            $table->string('accessToken');
            $table->string('refreshToken');
            $table->timestamp('tokenExpired')->useCurrent();
            $table->timestamp('refreshToken_expired')->useCurrent();
            // $table->timestamp('create-at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authen');
    }
};
