<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            if (!Schema::hasColumn('materias', 'periodo_academico_id')) {
                $table->foreignId('periodo_academico_id')
                    ->nullable()
                    ->constrained('periodos_academicos')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            if (Schema::hasColumn('materias', 'periodo_academico_id')) {
                $table->dropConstrainedForeignId('periodo_academico_id');
            }
        });
    }
};
