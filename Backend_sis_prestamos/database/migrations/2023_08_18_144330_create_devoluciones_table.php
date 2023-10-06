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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id('devolucion_id');
            $table->unsignedBigInteger('contrato_id');
            $table->decimal('monto_devolucion', 10, 2);
            $table->date('fecha_devolucion');
            $table->timestamps();

            $table->foreign('contrato_id')->references('contrato_id')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
