<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Agrega los campos del "libro de temas" a la tabla registros_clase.
// Un registro_clase ya representa UNA clase dada (fecha, docente, materia, curso, grupo).
// Con estos campos pasa a ser también el libro de temas digital,
// donde el docente anota qué se dio en esa clase.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registros_clase', function (Blueprint $table) {
            // Número de clase correlativo (1, 2, 3...) dentro del curso/grupo
            $table->unsignedSmallInteger('numero_clase')->nullable()->after('fecha');

            // Unidad del programa que se está dictando (ej: "Unidad 3 – POO")
            $table->string('unidad', 255)->nullable()->after('numero_clase');

            // Descripción libre de los temas dictados en la clase
            $table->text('temas_dictados')->nullable()->after('unidad');

            // Actividades realizadas (ejercicios, prácticos, evaluaciones, etc.)
            $table->text('actividades')->nullable()->after('temas_dictados');

            // Observaciones generales de la clase (cualquier dato relevante)
            $table->text('observaciones')->nullable()->after('actividades');

            // ¿Hubo un observador externo (preceptor, directivo, otro docente)?
            $table->boolean('hubo_observador')->default(false)->after('observaciones');

            // Nombre del observador si hubo uno
            $table->string('nombre_observador', 255)->nullable()->after('hubo_observador');
        });
    }

    public function down(): void
    {
        Schema::table('registros_clase', function (Blueprint $table) {
            $table->dropColumn([
                'numero_clase',
                'unidad',
                'temas_dictados',
                'actividades',
                'observaciones',
                'hubo_observador',
                'nombre_observador',
            ]);
        });
    }
};
