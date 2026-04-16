<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta tabla relaciona un docente con las materias que dicta,
// especificando en qué curso y grupo lo hace.
// Permite que el sistema sepa, cuando un profe inicia sesión,
// qué materia/curso/grupo puede gestionar.
//
// Ejemplo de fila: user_id=5, materia_id=1 (Programación),
//                  curso_id=2 (7°A), grupo_id=1 (Grupo 1)
// → "el profe X da Programación a 7°A Grupo 1"
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docente_materias', function (Blueprint $table) {
            $table->id();

            // El docente (usuario autenticado)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // La materia que dicta
            $table->foreignId('materia_id')
                  ->constrained('materias')
                  ->cascadeOnDelete();

            // En qué curso
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->cascadeOnDelete();

            // En qué grupo taller (nullable: si dicta a todo el curso sin división)
            $table->foreignId('grupo_id')
                  ->nullable()
                  ->constrained('grupos')
                  ->nullOnDelete();

            $table->timestamps();

            // Un docente no puede tener la misma combinación duplicada
            $table->unique(['user_id', 'materia_id', 'curso_id', 'grupo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_materias');
    }
};
