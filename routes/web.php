<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ComentarioRevisorController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ComprobacionesController;

use Illuminate\Support\Facades\Storage;
use App\Models\ComprobacionDocumento;
use App\Http\Middleware\CheckRole;
use App\Models\ComprobacionInfo;
use App\Models\Empleado;

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
})->name('profile')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

Route::get('/usuarios', [Usuarios::class, 'listaUsuarios'])
    ->name('usuarios.lista')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::get('/RegistrarUsuario', function () {
    return view('dashboard/usuarios/alta-usuario');
})->name('registrar.usuario')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::post('/guardar-usuario', [Usuarios::class, 'guardar'])->name('guardar.usuario')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::put('/usuarios/{id}/toggle', [Usuarios::class, 'toggleUsuario'])->name('usuarios.toggle')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::delete('/usuarios/{id}', [Usuarios::class, 'eliminarUsuario'])->name('usuarios.delete')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::get('/editar-usuario/{id}', [Usuarios::class, 'editarUsuario'])->name('editar.usuario')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::put('/usuario/{id}', [Usuarios::class, 'update'])->name('usuarios.update')
    ->middleware('role:SuperAdmin,Ciberseguridad');

Route::post('/perfil/actualizar', [Usuarios::class, 'profileUpdate'])->name('perfil.actualizar')
    ->middleware('role:SuperAdmin,Ciberseguridad');


/* Clientes */

Route::get('/clientes', [ClienteController::class, 'listaClientes'])
    ->name('clientes.lista')->middleware('role:SuperAdmin,Gerente General');

Route::post('/clientes-add', [ClienteController::class, 'agregarCliente'])
    ->name('add.clientes')->middleware('role:SuperAdmin,Gerente General');

Route::put('/clientes-update/{id}', [ClienteController::class, 'editarCliente'])
    ->name('update.clientes')
    ->middleware('role:SuperAdmin,Gerente General');


Route::match(['get', 'post'], '/clientes/{id}/toggle-status', [ClienteController::class, 'toggleStatus'])
    ->name('clientes.toggleStatus')
    ->middleware('role:SuperAdmin,Gerente General');

Route::get('/eliminar-cliente/{id}', [ClienteController::class, 'eliminarCliente'])
    ->name('eliminar.cliente')
    ->middleware('role:SuperAdmin,Gerente General');


/* Proyectos */

Route::get('/proyectos', [ProyectoController::class, 'listaProyectos'])
    ->name('proyectos.lista')
    ->middleware('role:SuperAdmin,Gerente de Ventas');

Route::post('/proyectos-add', [ProyectoController::class, 'agregarProyecto'])
    ->name('add.proyectos')
    ->middleware('role:SuperAdmin,Gerente de Ventas');

Route::put('/proyectos-update/{id}', [ProyectoController::class, 'editarProyecto'])
    ->name('update.proyectos')
    ->middleware('role:SuperAdmin,Gerente de Ventas');

Route::match(['get', 'post'], '/proyectos/{id}/toggle-status', [ProyectoController::class, 'toggleStatus'])
    ->name('proyectos.toggleStatus')
    ->middleware('role:SuperAdmin,Gerente de Ventas');

Route::get('/eliminar-proyecto/{id}', [ProyectoController::class, 'eliminarProyecto'])
    ->name('proyectos.eliminar')
    ->middleware('role:SuperAdmin,Gerente de Ventas');



/* Empleados */

Route::get('/empleados', [EmpleadoController::class, 'listaEmpleados'])
    ->name('empleados.lista')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::match(['get', 'post'], '/empleados/{id}/toggle-status', [EmpleadoController::class, 'toggleStatus'])
    ->name('empleados.toggleStatus')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::get('/altaEmpleado', function () {
    return view('dashboard/empleados/alta-empleado');
})->name('alta.empleado')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::post('/guardar-empleado', [EmpleadoController::class, 'agregarEmpleado'])
    ->name('add.empleado')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::get('/editar-empleado/{id}', [EmpleadoController::class, 'cargarEmpleado'])
    ->name('cargar.empleado')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::put('/update-empleado/{id}', [EmpleadoController::class, 'actualizarEmpleado'])
    ->name('update.empleado')
    ->middleware('role:SuperAdmin,Recursos Humanos');


Route::get('/archivo-empleado/{id}', [EmpleadoController::class, 'documentoEmpleado'])
    ->name('documentos.empleado')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::post('/documento-empleado/{id}', [EmpleadoController::class, 'addDocumentoEmpleado'])
    ->name('documentos.empleado.guardar')
    ->middleware('role:SuperAdmin,Recursos Humanos');

Route::get('/documentos/empleado/{id}/descargar/{tipo}', [EmpleadoController::class, 'descargarDocumento'])
    ->name('documentos.empleado.descargar')
    ->middleware('role:SuperAdmin,Recursos Humanos');



/* Solicitud de gastos */


Route::get('/solicitud', [SolicitudController::class, 'solicitud'])
    ->name('solicitud')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

Route::post('/guardar-solicitud', [SolicitudController::class, 'guardarSolicitud'])
    ->name('guardar.solicitud')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

/*Route::get('/solicitud', function () {
    return view('gastos/viaticos/solicitud');
})->name('solicitud');*/




/* Autorización solicitudes*/

Route::get('/autorizar', [SolicitudController::class, 'mostrarAutorizaciones'])->name('autorizar')
    ->middleware('nivelOrole:1,2,3,SuperAdmin');

Route::get('/autorizarViatico/{id}', [SolicitudController::class, 'revisarAutorizacionSolicitud'])->name('revisarAutorizacionSolicitud')
    ->middleware('nivelOrole:1,2,3,SuperAdmin');


Route::post('/comentarios_revisor', [ComentarioRevisorController::class, 'agregarComentarioRevisor'])->name('comentarios_revisor.agregar');

Route::post('/actualizar-estado/{id}', [SolicitudController::class, 'actualizarEstado'])->name('actualizar_estado');


/* Autorización comprobaciones*/

Route::get('/autorizar-comprobacion', [ComprobacionesController::class, 'autorizarVerComprobaciones'])
    ->name('autorizar.comprobacion')
    ->middleware('nivelOrole:1,2,3,SuperAdmin');

Route::get('/autorizar-comprobacion/{id}', [ComprobacionesController::class, 'revisarAutorizacionComprobacion'])->name('revisarAutorizacionComprobacion')
    ->middleware('nivelOrole:1,2,3,SuperAdmin');

Route::post('/comentarios_revisor/comprobacion', [ComentarioRevisorController::class, 'agregarComentarioRevisorComprobación'])->name('comentarios_revisor_comprobacion.agregar');

Route::post('/actualizar-estado/comprobacion/{id}', [ComprobacionesController::class, 'actualizarEstadoComprobacion'])->name('actualizar_estado_comprobacion');



Route::get('/autorizarComprobacion', function () {
    return view('gastos/viaticos/autorizarComprobacion');
})->name('autorizarComprobacion');

Route::get('/autorizarReposicion', function () {
    return view('gastos/viaticos/autorizarReposicion');
})->name('autorizarReposicion');





/* Hisotiral de gastos */

Route::get('/historial', [SolicitudController::class, 'historialVer'])
    ->name('historial')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

Route::get('/historial-solicitud/{id}', [SolicitudController::class, 'historialSolicitud'])
    ->name('historial.solicitud')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');


Route::get('/historial-comprobacion/{id}', [ComprobacionesController::class, 'historialComprobacion'])
    ->name('historial.comprobacion')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');




// Descargar xml FACTURA
Route::get('/download-file/xml/{id}', function ($id) {
    $documento = ComprobacionDocumento::find($id);
    if ($documento && Storage::disk('public')->exists($documento->xml_path)) {
        $path = $documento->xml_path;
        $originalName = basename($path); // Extrae solo el nombre del archivo
        return response()->download(storage_path('app/public/' . $path), $originalName);
    } else {
        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }
})->name('descargar.xml');


// Descargar pdf FACTURA
Route::get('/download-file/pdf/{id}', function ($id) {
    $documento = ComprobacionDocumento::find($id);
    if ($documento && Storage::disk('public')->exists($documento->pdf_path)) {
        $path = $documento->pdf_path;
        $originalName = basename($path); // Extrae solo el nombre del archivo
        return response()->download(storage_path('app/public/' . $path), $originalName);
    } else {
        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }
});

//_________________


Route::get('/historial-reposicion', function () {
    return view('gastos/viaticos/historial/historial-reposicion');
})->name('historial.reposicion');






Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');


Route::post('/notificaciones/{id}/marcar-como-leida', [NotificacionController::class, 'marcarComoLeida'])->name('notificaciones.marcarComoLeida');


/* Comprobaciones */


Route::get('/comprobaciones', [ComprobacionesController::class, 'listaComprobaciones'])
    ->name('comprobaciones.lista')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');


Route::get('/comprobacion/{id}', [ComprobacionesController::class, 'verComprobacion'])
    ->name('ver.comprobacion')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

Route::post('/save-comprobacion/{id}', [ComprobacionesController::class, 'store'])
    ->name('guardar.comprobacion')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');




Route::get('/reposicion', function () {
    return view('gastos/viaticos/reposicion');
})->name('reposicion');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');





Route::get('/pruebasPDF', function () {
    return view('gastos/viaticos/historial/cheque');
})->name('pruebas');


// PDF generados en historial
Route::get('/cheque/{id}', [SolicitudController::class, 'verCheque'])
    ->name('generar.cheque')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');

Route::get('/comprobacion/pdf/{id}', [ComprobacionesController::class, 'verComprobacionGasto'])
    ->name('generar.comprobacion')
    ->middleware('role:SuperAdmin,Calidad,Ciberseguridad,Contador,Empleado,Gerencia,Gerente de Ventas,Gerente General,Recursos Humanos');
