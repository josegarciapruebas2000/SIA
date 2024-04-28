<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\ClienteController;
use App\Http\Middleware\CheckRole;


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

Route::view('/error/403', 'errors.403')->name('error.403');

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

/* Usuarios */

Route::get('/perfil', function () {
    return view('dashboard/usuarios/profile');
})->name('profile');

Route::get('/usuarios', [Usuarios::class, 'listaUsuarios'])
    ->name('usuarios.lista')
    ->middleware('role:SuperAdmin,Administrador');

Route::get('/RegistrarUsuario', function () {
    return view('dashboard/usuarios/alta-usuario');
})->name('registrar.usuario')->middleware('role:SuperAdmin,Administrador');

Route::post('/guardar-usuario', [Usuarios::class, 'guardar'])->name('guardar.usuario');

Route::put('/usuarios/{id}/toggle', [Usuarios::class, 'toggleUsuario'])->name('usuarios.toggle');
Route::delete('/usuarios/{id}', [Usuarios::class, 'eliminarUsuario'])->name('usuarios.delete');

Route::get('/editar-usuario/{id}', [Usuarios::class, 'editarUsuario'])->name('editar.usuario')->middleware('role:SuperAdmin,Administrador');

Route::put('/usuario/{id}', [Usuarios::class, 'update'])->name('usuarios.update');

Route::post('/perfil/actualizar', [Usuarios::class, 'profileUpdate'])->name('perfil.actualizar');


/* Clientes */

Route::get('/clientes', [ClienteController::class, 'listaClientes'])
    ->name('clientes.lista')->middleware('role:SuperAdmin,Administrador');

Route::post('/clientes-add', [ClienteController::class, 'agregarCliente'])
    ->name('add.clientes')->middleware('role:SuperAdmin,Administrador');

Route::put('/clientes-update/{id}', [ClienteController::class, 'editarCliente'])
    ->name('update.clientes')
    ->middleware('role:SuperAdmin,Administrador');

Route::put('/status-habilitar/{id}', [ClienteController::class, 'habilitarStatus'])
    ->name('habilitar.status')
    ->middleware('role:SuperAdmin,Administrador');

Route::put('/status-dehabilitar/{id}', [ClienteController::class, 'deshabilitarStatus'])
    ->name('deshabilitar.status')
    ->middleware('role:SuperAdmin,Administrador');

Route::match(['get', 'post'], '/clientes/{id}/toggle-status', [ClienteController::class, 'toggleStatus'])
    ->name('clientes.toggleStatus')
    ->middleware('role:SuperAdmin,Administrador');

Route::get('/eliminar-cliente/{id}', [ClienteController::class, 'eliminarCliente'])
    ->name('eliminar.cliente')
    ->middleware('role:SuperAdmin,Administrador');




Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/solicitud', function () {
    return view('gastos/viaticos/solicitud');
})->name('solicitud');

Route::get('/comprobaciones', function () {
    return view('gastos/viaticos/comprobaciones');
})->name('comprobaciones');

Route::get('/comprobacion', function () {
    return view('gastos/viaticos/comprobacion');
})->name('comprobacion');

Route::get('/reposicion', function () {
    return view('gastos/viaticos/reposicion');
})->name('reposicion');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
