<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->string('token')->unique();
            $table->string('plataforma')->nullable(); // android/ios
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('device_tokens');
    }
};
