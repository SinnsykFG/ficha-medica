<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut', 12)->unique(); // Ej: 12345678-9
            $table->string('nombres', 100);
            $table->string('apellidos', 150);
            $table->string('direccion', 255);
            $table->string('ciudad', 100);
            $table->string('telefono', 20);
            $table->string('email', 150)->unique();
            $table->date('fecha_nacimiento');
            $table->string('estado_civil', 50);
            $table->text('comentarios')->nullable();
            $table->timestamps(); // created_at y updated_at automáticos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
