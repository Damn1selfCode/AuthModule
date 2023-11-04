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
        Schema::create('videos', function (Blueprint $table) {

            $table->id('id_video');
            $table->unsignedBigInteger('id_cat');
            $table->text('titulo_video');
            $table->text('descripcion_video');
            $table->text('medios_video');
            $table->text('imagen_video')->nullable();
            $table->integer('vista_gratuita');
            $table->timestamp('fecha_video')->useCurrent();
            $table->foreign('id_cat')->references('id_cat')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
