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
        Schema::create('ingresos_egresos', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('ingreso')->nullable();
            $table->decimal('egreso')->nullable();
            $table->integer('amortizacion_id')->nullable();
            $table->number('Renovacion_id')->nullable();
            $table->number('venta_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->timestamps();
            $table->foreign('amortizacion_id')->references('amortizacion_id')->on('amortizaciones');
            $table->foreign('Renovacion_id')->references('Renovacion_id')->on('revaciones_finalizaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
