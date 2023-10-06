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
        Schema::create('prendas', function (Blueprint $table) {
            $table->id('prenda_id');
            $table->unsignedBigInteger('contrato_id');
            $table->decimal('valor_prenda', 10, 2);
            $table->string('descripcion', 20);
            $table->string('estado', 20);
            $table->timestamps();

            $table->foreign('contrato_id')->references('contrato_id')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prendas');
    }
};