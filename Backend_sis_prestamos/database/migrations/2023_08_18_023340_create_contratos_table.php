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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id('contrato_id');
            $table->Integer('CI_cliente');
            $table->decimal('monto_prestamo', 10, 2);
            $table->decimal('tasa_interes', 5, 2);
            $table->date('fecha_inicio')->nullable()->date_format('d/m/Y');
            $table->date('fecha_fin')->nullable();
            $table->string('estado_contrato');
            $table->timestamps();
            $table->foreign('CI_cliente')->references('CI')->on('clientes');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
