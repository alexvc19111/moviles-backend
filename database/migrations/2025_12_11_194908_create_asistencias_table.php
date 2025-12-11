<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('clase_id')
                ->constrained('clases')
                ->onDelete('cascade');

            $table->foreignId('alumno_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->enum('estado', ['presente', 'ausente', 'tarde'])->default('presente');
            $table->string('observacion')->nullable();

            $table->foreignId('marcado_por')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['clase_id', 'alumno_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('asistencias');
    }
};
