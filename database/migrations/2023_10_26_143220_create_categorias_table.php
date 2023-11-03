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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_cat');
            $table->text('nombre_categoria');
            $table->text('ruta_categoria');
            $table->text('descripcion_categoria');
            $table->text('icono_categoria')->nullable();
            $table->text('color_categoria')->nullable();
            $table->timestamp('fecha_categoria')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
