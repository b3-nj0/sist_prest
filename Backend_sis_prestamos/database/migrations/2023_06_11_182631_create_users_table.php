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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->unique();
            $table->string('nombre')->unique();
            $table->string('password');
            //$table->foreignId('rol')->constrained('roles', 'id');
            //$table->foreignId('Gerente')->nullable()->constrained('users', 'id');
            //$table->boolean('Gerente')->default(false); // Cambio realizado aquí
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};