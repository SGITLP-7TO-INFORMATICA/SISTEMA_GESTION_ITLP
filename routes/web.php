<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocenteController\DocenteController;
use App\Http\Controllers\AlumnoController\AlumnoController;
use App\Http\Controllers\MateriaController\MateriaController;
use App\Http\Controllers\DocenteAdminController\DocenteAdminController;
use App\Http\Controllers\CursoController\CursoController;
use App\Http\Controllers\MateriaDictadoController\MateriaDictadoController;
use App\Http\Controllers\AnioController\AnioController;

// ══════════════════════════════════════════════════
// RUTAS PÚBLICAS — no requieren estar autenticado
// ══════════════════════════════════════════════════

// GET  /login  → muestra el formulario de login
// POST /login  → procesa el intento de login
// POST /logout → cierra la sesión (POST para protegerlo con CSRF)
//
// La ruta 'login' es especial en Laravel: cuando un usuario intenta
// acceder a una ruta protegida sin autenticarse, el middleware 'auth'
// lo redirige automáticamente a la ruta nombrada 'login'.
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ══════════════════════════════════════════════════
// RUTAS PROTEGIDAS — requieren sesión activa
// ══════════════════════════════════════════════════
//
// Route::middleware('auth') envuelve un grupo de rutas con el middleware
// de autenticación de Laravel. Si el usuario no está logueado,
// lo redirige a la ruta 'login' definida arriba.
Route::middleware('auth')->group(function () {

    // ── Panel principal ──
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');


    // ── Módulo Docentes ──

    // Tomar lista (GET muestra el form, POST guarda la asistencia)
    Route::get('/docentes/tomar-lista', [DocenteController::class, 'tomarLista'])
         ->name('docentes.tomar-lista');

    Route::post('/docentes/tomar-lista', [DocenteController::class, 'guardarLista'])
         ->name('docentes.tomar-lista.guardar');

    // Endpoint AJAX: devuelve JSON con los alumnos de un curso+grupo.
    Route::get('/docentes/alumnos', [DocenteController::class, 'getAlumnos'])
         ->name('docentes.alumnos');

    // Endpoint AJAX: devuelve las asistencias de un registro de clase (para pre-llenar).
    Route::get('/docentes/asistencias-registro', [DocenteController::class, 'getAsistenciasRegistro'])
         ->name('docentes.asistencias-registro');

    // Endpoint AJAX: devuelve el siguiente número de clase para un dictado.
    Route::get('/docentes/siguiente-numero-clase', [DocenteController::class, 'getSiguienteNumeroClase'])
         ->name('docentes.siguiente-numero-clase');

    // Libro de temas (GET muestra el form, POST guarda la entrada)
    Route::get('/docentes/libro-temas', [DocenteController::class, 'libroTemas'])
         ->name('docentes.libro-temas');

    Route::post('/docentes/libro-temas', [DocenteController::class, 'guardarLibroTemas'])
         ->name('docentes.libro-temas.guardar');

    // Exportar registros de clases a Excel
    Route::get('/docentes/exportar-registros', [DocenteController::class, 'exportarRegistros'])
         ->name('docentes.exportar-registros');

    Route::post('/docentes/exportar-registros', [DocenteController::class, 'descargarExcel'])
         ->name('docentes.exportar-registros.descargar');

    // Trabajos prácticos ABM
    Route::get('/docentes/trabajos-practicos', [DocenteController::class, 'trabajosPracticos'])
         ->name('docentes.trabajos-practicos');

    Route::post('/docentes/trabajos-practicos', [DocenteController::class, 'guardarTrabajo'])
         ->name('docentes.trabajos-practicos.guardar');

    Route::delete('/docentes/trabajos-practicos/{id}', [DocenteController::class, 'eliminarTrabajo'])
         ->name('docentes.trabajos-practicos.eliminar');

    Route::get('/docentes/alumnos-trabajo', [DocenteController::class, 'getAlumnosTrabajo'])
         ->name('docentes.alumnos-trabajo');


    // ── Módulo Administración — Alumnos ──

    Route::get('/administracion/alumnos', [AlumnoController::class, 'index'])
         ->name('administracion.alumnos');

    Route::post('/administracion/alumnos', [AlumnoController::class, 'guardar'])
         ->name('administracion.alumnos.guardar');

    Route::get('/administracion/alumnos/materias', [AlumnoController::class, 'getMaterias'])
         ->name('administracion.alumnos.materias');

    Route::get('/administracion/alumnos/asistencias', [AlumnoController::class, 'getAsistencias'])
         ->name('administracion.alumnos.asistencias');


    // ── Módulo Administración — Materias ──

    Route::get('/administracion/materias', [MateriaController::class, 'index'])
         ->name('administracion.materias');

    Route::post('/administracion/materias', [MateriaController::class, 'guardar'])
         ->name('administracion.materias.guardar');

    Route::delete('/administracion/materias/{id}', [MateriaController::class, 'eliminar'])
         ->name('administracion.materias.eliminar');


    // ── Módulo Administración — Docentes ──

    Route::get('/administracion/docentes', [DocenteAdminController::class, 'index'])
         ->name('administracion.docentes');

    Route::post('/administracion/docentes', [DocenteAdminController::class, 'guardar'])
         ->name('administracion.docentes.guardar');

    Route::get('/administracion/docentes/materias', [DocenteAdminController::class, 'getMaterias'])
         ->name('administracion.docentes.materias');


    // ── Módulo Administración — Cursos ──

    Route::get('/administracion/cursos', [CursoController::class, 'index'])
         ->name('administracion.cursos');

    Route::post('/administracion/cursos', [CursoController::class, 'guardar'])
         ->name('administracion.cursos.guardar');

    Route::delete('/administracion/cursos/{id}', [CursoController::class, 'eliminar'])
         ->name('administracion.cursos.eliminar');


    // ── Módulo Administración — Dictado de Materias ──

    Route::get('/administracion/materias-dictado', [MateriaDictadoController::class, 'index'])
         ->name('administracion.materias-dictado');

    Route::post('/administracion/materias-dictado', [MateriaDictadoController::class, 'guardar'])
         ->name('administracion.materias-dictado.guardar');

    Route::delete('/administracion/materias-dictado/{id}', [MateriaDictadoController::class, 'eliminar'])
         ->name('administracion.materias-dictado.eliminar');

    Route::get('/administracion/materias-dictado/{id}/cargar', [MateriaDictadoController::class, 'cargar'])
         ->name('administracion.materias-dictado.cargar');


    // ── Módulo Administración — Años escolares ──

    Route::get('/administracion/anios', [AnioController::class, 'index'])
         ->name('administracion.anios');

    Route::post('/administracion/anios', [AnioController::class, 'guardar'])
         ->name('administracion.anios.guardar');

    Route::delete('/administracion/anios/{id}', [AnioController::class, 'eliminar'])
         ->name('administracion.anios.eliminar');

});
