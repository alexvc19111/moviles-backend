<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->onDelete('cascade');

            $table->date('fecha_matricula')->nullable();
            $table->string('estado')->default('activo');

            $table->timestamps();

            $table->unique(['alumno_id', 'materia_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('inscripciones');
    }
};
