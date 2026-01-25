<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            if (!Schema::hasColumn('materias', 'color_hex')) {
                $table->string('color_hex')->nullable();
            }

            if (!Schema::hasColumn('materias', 'icon')) {
                $table->string('icon')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            if (Schema::hasColumn('materias', 'color_hex')) {
                $table->dropColumn('color_hex');
            }

            if (Schema::hasColumn('materias', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
