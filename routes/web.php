<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
})->name('login');

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