<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notificacion_leidas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aviso_id')
                ->constrained('avisos')
                ->onDelete('cascade');

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->boolean('leido')->default(false);
            $table->timestamp('leido_at')->nullable();

            $table->timestamps();

            $table->unique(['aviso_id', 'usuario_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('notificacion_leidas');
    }
};

