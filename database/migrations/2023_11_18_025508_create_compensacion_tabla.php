<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compensacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_origen'); //usuario origen
            $table->unsignedBigInteger('user_id_destino'); //usuario beneficiado
            $table->decimal('monto', 18, 2);
            $table->timestamp('fecha_compensacion');
            $table->foreign('user_id_origen')->references('id')->on('users');
            $table->foreign('user_id_destino')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compensacion');
    }
};
