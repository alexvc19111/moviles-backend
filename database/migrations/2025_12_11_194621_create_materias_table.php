<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
             $table->foreignId('periodo_academico_id')
          ->constrained('periodos_academicos')
          ->onDelete('cascade');

          $table->foreignId('docente_id')
                ->constrained('docentes')
                ->onDelete('cascade');
                
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->text('descripcion')->nullable();
            $table->integer('creditos');
            $table->string('color_hex')->nullable();
            $table->string('icon')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('materias');
    }
};
