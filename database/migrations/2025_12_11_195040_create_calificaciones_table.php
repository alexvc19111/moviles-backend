<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->onDelete('cascade');

            $table->string('tipo')->default('parcial'); // parcial, final, tarea, etc.
            $table->decimal('nota', 5, 2);
            $table->text('descripcion')->nullable();
            $table->date('fecha')->nullable();

            $table->foreignId('creado_por')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('calificaciones');
    }
};
