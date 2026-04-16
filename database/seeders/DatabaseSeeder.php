<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Materia;
use App\Models\Curso;
use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\DocenteMateria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// El Seeder es el "script de datos iniciales" de Laravel.
// Lo corrés con: php artisan db:seed
// (o junto con las migraciones: php artisan migrate --seed)
// Sirve para poblar la BD con datos de prueba o datos base del sistema.
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. USUARIO DOCENTE (para hacer login) ──────────────────────────
        // Hash::make() genera el hash bcrypt de la contraseña.
        // En producción nunca hardcodear passwords; acá es solo para desarrollo.
        $docente = User::create([
            'name'     => 'Canclini Camilo',
            'email'    => 'ccanclini@itlp.edu.ar',
            'password' => Hash::make('password123'),
        ]);

        // Usuario de prueba extra (para que los alumnos pasantes tengan con qué probar)
        $docente2 = User::create([
            'name'     => 'Martínez Laura',
            'email'    => 'lmartinez@itlp.edu.ar',
            'password' => Hash::make('password123'),
        ]);


        // ── 2. MATERIAS ───────────────────────────────────────────────────
        $programacion = Materia::create(['nombre' => 'Programación',   'descripcion' => 'Desarrollo de software y algoritmos']);
        $baseDatos    = Materia::create(['nombre' => 'Base de Datos',  'descripcion' => 'Diseño y gestión de bases de datos']);
        $redes        = Materia::create(['nombre' => 'Redes',          'descripcion' => 'Redes de computadoras y protocolos']);
        $sistemas     = Materia::create(['nombre' => 'Sistemas',       'descripcion' => 'Análisis y diseño de sistemas']);
        $matematica   = Materia::create(['nombre' => 'Matemática',     'descripcion' => null]);


        // ── 3. CURSOS ─────────────────────────────────────────────────────
        $septA = Curso::create(['nombre' => '7°A', 'division' => 'A']);
        $septB = Curso::create(['nombre' => '7°B', 'division' => 'B']);
        $sextA = Curso::create(['nombre' => '6°A', 'division' => 'A']);


        // ── 4. GRUPOS TALLER ──────────────────────────────────────────────
        $grupo1 = Grupo::create(['nombre' => 'Grupo 1']);
        $grupo2 = Grupo::create(['nombre' => 'Grupo 2']);
        $grupo3 = Grupo::create(['nombre' => 'Grupo 3']);


        // ── 5. ALUMNOS ────────────────────────────────────────────────────
        // 7°A - Grupo 1
        $alumnos7aG1 = [
            ['nombre' => 'Agustina', 'apellido' => 'Fernández'],
            ['nombre' => 'Bruno',    'apellido' => 'Gómez'],
            ['nombre' => 'Carla',    'apellido' => 'Ríos'],
            ['nombre' => 'Diego',    'apellido' => 'Peralta'],
            ['nombre' => 'Elena',    'apellido' => 'Suárez'],
            ['nombre' => 'Franco',   'apellido' => 'Álvarez'],
        ];
        foreach ($alumnos7aG1 as $a) {
            Alumno::create([...$a, 'curso_id' => $septA->id, 'grupo_id' => $grupo1->id]);
        }

        // 7°A - Grupo 2
        $alumnos7aG2 = [
            ['nombre' => 'Gabriela', 'apellido' => 'Torres'],
            ['nombre' => 'Hernán',   'apellido' => 'Vega'],
            ['nombre' => 'Inés',     'apellido' => 'Luna'],
            ['nombre' => 'Joaquín',  'apellido' => 'Medina'],
            ['nombre' => 'Karen',    'apellido' => 'Ibáñez'],
        ];
        foreach ($alumnos7aG2 as $a) {
            Alumno::create([...$a, 'curso_id' => $septA->id, 'grupo_id' => $grupo2->id]);
        }

        // 7°B - Grupo 1
        $alumnos7bG1 = [
            ['nombre' => 'Lucas',   'apellido' => 'Morales'],
            ['nombre' => 'Martina', 'apellido' => 'Castro'],
            ['nombre' => 'Nicolás', 'apellido' => 'Romero'],
            ['nombre' => 'Olivia',  'apellido' => 'Pérez'],
            ['nombre' => 'Pablo',   'apellido' => 'Sosa'],
        ];
        foreach ($alumnos7bG1 as $a) {
            Alumno::create([...$a, 'curso_id' => $septB->id, 'grupo_id' => $grupo1->id]);
        }

        // 6°A - Grupo 1
        $alumnos6aG1 = [
            ['nombre' => 'Romina',  'apellido' => 'Díaz'],
            ['nombre' => 'Sebastián','apellido' => 'Gutiérrez'],
            ['nombre' => 'Tamara',  'apellido' => 'Herrera'],
        ];
        foreach ($alumnos6aG1 as $a) {
            Alumno::create([...$a, 'curso_id' => $sextA->id, 'grupo_id' => $grupo1->id]);
        }


        // ── 6. ASIGNACIONES DOCENTE ↔ MATERIA/CURSO/GRUPO ────────────────
        // docente (Canclini) da:
        //   - Programación a 7°A Grupo 1
        //   - Programación a 7°A Grupo 2
        //   - Base de Datos a 7°B Grupo 1
        DocenteMateria::create([
            'user_id'    => $docente->id,
            'materia_id' => $programacion->id,
            'curso_id'   => $septA->id,
            'grupo_id'   => $grupo1->id,
        ]);
        DocenteMateria::create([
            'user_id'    => $docente->id,
            'materia_id' => $programacion->id,
            'curso_id'   => $septA->id,
            'grupo_id'   => $grupo2->id,
        ]);
        DocenteMateria::create([
            'user_id'    => $docente->id,
            'materia_id' => $baseDatos->id,
            'curso_id'   => $septB->id,
            'grupo_id'   => $grupo1->id,
        ]);

        // docente2 (Martínez) da:
        //   - Matemática a 6°A Grupo 1
        //   - Sistemas a 7°A Grupo 1
        DocenteMateria::create([
            'user_id'    => $docente2->id,
            'materia_id' => $matematica->id,
            'curso_id'   => $sextA->id,
            'grupo_id'   => $grupo1->id,
        ]);
        DocenteMateria::create([
            'user_id'    => $docente2->id,
            'materia_id' => $sistemas->id,
            'curso_id'   => $septA->id,
            'grupo_id'   => $grupo1->id,
        ]);
    }
}
