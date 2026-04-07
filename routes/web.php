<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocenteController; 

/* Route::get('/', function () {
    return view('welcome');
}); */

// ======================
// VIEWS MODULO PRINCIPAL
// ======================
Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

// ======================
// VIEWS MODULO DOCENTES
// ======================

// Muestra el formulario
Route::get('/docentes/tomar-lista', [DocenteController::class, 'tomarLista'])
     ->name('docentes.tomar-lista');

// Recibe el formulario — por ahora solo hace dd() para ver los datos
Route::post('/docentes/tomar-lista', [DocenteController::class, 'guardarLista'])
     ->name('docentes.tomar-lista.guardar');