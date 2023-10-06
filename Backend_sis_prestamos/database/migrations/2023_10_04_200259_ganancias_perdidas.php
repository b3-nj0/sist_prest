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
        Schema::create('ganancias_perdidas', function (Blueprint $table) {
            $table->id('ganancias_id');
            $table->number('monto_ganancia')->nullable();
            $table->number('monto_perdida')-> nullable();
            $table->decimal('capital');
            $table->number('id');
            $table->timestamps();
            $table->foreign('id')-> references('id')-> on ('ingresos_egresos');
            $table->foreign('capital')-> references('id_captal')-> on ('capital');
            
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
