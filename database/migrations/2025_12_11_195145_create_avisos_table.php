<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensaje');

            $table->enum('destinatario_tipo', ['todo', 'materia', 'alumno']);
            $table->unsignedBigInteger('destinatario_id')->nullable();

            $table->foreignId('creado_por')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('avisos');
    }
};
