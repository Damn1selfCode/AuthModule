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
        Schema::create('suscripcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Campo de referencia al ID de la tabla users
            $table->integer('suscripcion');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripcion');
    }
};
