<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
Route::get('/crear-usuario', [UsuarioController::class, 'create'])->name('usuarios.crear');
Route::post('/guardar-usuario', [UsuarioController::class, 'store'])->name('usuarios.guardar');
Route::get('/editar-usuario/{id}', [UsuarioController::class, 'edit'])->name('usuarios.editar');
Route::post('/actualizar-usuario/{id}', [UsuarioController::class, 'update'])->name('usuarios.actualizar');
Route::get('/destruir-usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destruir');

Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas');
Route::get('/reservar', [UsuarioController::class, 'create'])->name('reservas.reservar');