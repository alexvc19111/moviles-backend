<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')
                ->constrained('usuarios')
                ->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->integer('faltas')->default(0);
            $table->integer('justificadas')->default(0);
            $table->integer('total_clases')->default(0);

            $table->timestamps();

            $table->unique(['materia_id', 'alumno_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('asistencias');
    }
};
