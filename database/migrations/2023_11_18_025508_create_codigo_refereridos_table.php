<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('codigo_referido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Campo de referencia al ID de la tabla users
            $table->string('codigopublico')->unique();
            $table->string('codigoprivado')->unique();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_referido');
    }
};
