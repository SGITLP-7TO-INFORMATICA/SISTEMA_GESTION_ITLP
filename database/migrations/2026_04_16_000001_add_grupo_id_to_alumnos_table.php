<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Agrega grupo_id a la tabla alumnos.
// En el instituto, los alumnos de un curso se dividen en "grupos taller"
// (ej: 7°A tiene Grupo 1 y Grupo 2 para materias de taller).
// Es nullable porque en materias teóricas el grupo puede no aplicar.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->foreignId('grupo_id')
                  ->nullable()
                  ->after('curso_id')
                  ->constrained('grupos')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            $table->dropColumn('grupo_id');
        });
    }
};
