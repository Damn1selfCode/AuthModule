<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('soporte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('remitente');
            $table->unsignedBigInteger('receptor');
            $table->text('asunto');
            $table->text('mensaje');
            $table->text('adjuntos')->nullable();
            $table->text('tipo');
            $table->json('papelera')->nullable(); // Nuevo campo para manejar la papelera
            $table->timestamp('fecha_soporte');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soporte');
    }
};
