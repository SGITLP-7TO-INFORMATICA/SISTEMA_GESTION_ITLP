<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocenteController;

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
    // Lo llama el JavaScript de la vista tomar-lista cuando el profe
    // selecciona curso y grupo.
    Route::get('/docentes/alumnos', [DocenteController::class, 'getAlumnos'])
         ->name('docentes.alumnos');

    // Libro de temas (GET muestra el form, POST guarda la entrada)
    Route::get('/docentes/libro-temas', [DocenteController::class, 'libroTemas'])
         ->name('docentes.libro-temas');

    Route::post('/docentes/libro-temas', [DocenteController::class, 'guardarLibroTemas'])
         ->name('docentes.libro-temas.guardar');

});
