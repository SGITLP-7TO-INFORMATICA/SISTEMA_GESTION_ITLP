<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registros_clase', function (Blueprint $table) {
            $table->id();

            $table->foreignId('docente_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('curso_id')
                ->constrained('cursos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('grupo_id')
                ->nullable()
                ->constrained('grupos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->date('fecha');

            $table->timestamps();

            // Opcional pero MUY útil:
            $table->index(['fecha', 'curso_id']);
            $table->index(['docente_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_clase');
    }
};
