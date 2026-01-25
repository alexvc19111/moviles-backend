<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            // Si existe la vieja columna, la eliminamos
            if (Schema::hasColumn('materias', 'periodo_id')) {
                $table->dropColumn('periodo_id');
            }

            // Si no existe la nueva, la creamos
            if (!Schema::hasColumn('materias', 'periodo_academico_id')) {
                $table->foreignId('periodo_academico_id')
                    ->constrained('periodos_academicos')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            if (Schema::hasColumn('materias', 'periodo_academico_id')) {
                $table->dropConstrainedForeignId('periodo_academico_id');
            }

            if (!Schema::hasColumn('materias', 'periodo_id')) {
                $table->unsignedBigInteger('periodo_id');
            }
        });
    }
};
