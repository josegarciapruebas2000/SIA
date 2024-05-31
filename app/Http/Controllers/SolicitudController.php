<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use App\Models\SolicitudViaticos;
use App\Models\ComentarioRevisor;
use App\Models\Notificacion;
use App\Models\ComprobacionInfo;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function solicitud()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, obtener todos los proyectos y todos los revisores
        if ($user->role === 'SuperAdmin') {
            $proyectos = Proyecto::where('status', 1)->get();
            $revisores = User::where('revisor', '1')->where('status', 1)->get();
        } else {
            // Obtener los proyectos asociados al usuario autenticado
            $proyectos = Proyecto::whereHas('usuarios', function ($query) use ($user) {
                $query->where('idUsuario', $user->id);
            })->where('status', 1)->get();

            // Determinar el nivel de revisores a mostrar basado en el nivel del usuario autenticado
            $nivelRevisor = $user->nivel + 1;

            // Obtener los revisores activos según el nivel del usuario autenticado
            $revisores = User::where('revisor', '1')
                ->where('status', 1)
                ->where('nivel', $nivelRevisor)
                ->get();
        }

        return view('gastos.viaticos.solicitud', compact('proyectos', 'revisores'));
    }



    public function guardarSolicitud(Request $request)
    {
        $request->validate([
            'solicitud' => 'required|string|max:30',
            'proyecto' => 'required|exists:PROYECTOS,idProy',
            'comentario' => 'required|string|max:40',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'revisor' => 'required|exists:users,id',
            'total_via' => 'required|numeric', // Agregar la validación para el campo total_via
        ]);

        // Obtener el ID del usuario autenticado
        $user_id = Auth::id();

        // Obtener el revisor
        $revisor = User::findOrFail($request->input('revisor'));

        // Guardar la solicitud en la base de datos
        $solicitud = new SolicitudViaticos();
        $solicitud->nombreSolicitud = $request->input('solicitud');
        $solicitud->idProy_via = $request->input('proyecto');
        $solicitud->comentario_via = $request->input('comentario');
        $solicitud->solicitudfecha_via = $request->input('fecha_inicio');
        $solicitud->solFinalFecha_via = $request->input('fecha_fin');
        $solicitud->revisor_id = $revisor->id;
        $solicitud->total_via = $request->input('total_via'); // Asignar el valor del campo total_via
        $solicitud->user_id = $user_id; // Asignar el ID del usuario autenticado

        // Asignar el nivel basado en el revisor
        $solicitud->nivel = $revisor->nivel;

        $solicitud->save();

        // Crear una nueva notificación 
        $contenido = "Tienes una nueva solicitud por aprobar del folio {$solicitud->FOLIO_via}";
        $notificacion = new Notificacion([
            'titulo' => 'Nueva solicitud', // Asignar un título a la notificación
            'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
            'leida' => false,
            'nivel' => $revisor->nivel, // Asignar el nivel del revisor a la notificación
            'folio_via' => $solicitud->FOLIO_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
        ]);


        // Guardar la notificación
        $notificacion->save();

        // Redirigir al dashboard con el mensaje de éxito
        return redirect()->route('dashboard')->with(['showConfirmationModal' => true, 'success' => '¡Tu solicitud ha sido enviada con éxito!']);
    }


    // * Solicitudes - Comprobaciones  *
    public function mostrarAutorizaciones()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, obtener todas las solicitudes y comprobaciones que no sean de nivel 4
        if ($user->role === 'SuperAdmin') {
            $solicitudes = SolicitudViaticos::where('nivel', '<>', 4)
                ->with('proyecto')
                ->get();

            $foliosNivel4 = SolicitudViaticos::where('nivel', 4)->pluck('FOLIO_via');

            // Suponiendo que ComprobacionInfo tiene una relación llamada 'solicitudViatico' definida que vincula a través de 'folio_via'
            $comprobaciones = ComprobacionInfo::with('solicitudViatico')
                ->where('nivel', '<>', 4)
                ->whereIn('folio_via', $foliosNivel4)
                ->get();
        } else {
            // Obtener el nivel del usuario autenticado
            $nivelUsuario = $user->nivel;

            // Obtener las solicitudes de viáticos y comprobaciones asociadas al nivel del usuario autenticado y que no sean de nivel 4
            $solicitudes = SolicitudViaticos::where('nivel', $nivelUsuario)
                ->where('nivel', '<>', 4)
                ->with('proyecto')
                ->get();
            $comprobaciones = ComprobacionInfo::where('nivel', $nivelUsuario)
                ->where('nivel', '<>', 4)
                ->get();
        }

        // Calcular la suma total de viáticos y montos comprobados
        $totalSumViaticos = $solicitudes->sum('total_via');
        $totalSumComprobado = $comprobaciones->sum('monto_comprobado');

        // Pasar las solicitudes, comprobaciones y las sumas totales a la vista
        return view('gastos.viaticos.autorizar', [
            'solicitudes' => $solicitudes,
            'comprobaciones' => $comprobaciones,
            'totalSumViaticos' => $totalSumViaticos,
            'totalSumComprobado' => $totalSumComprobado
        ]);
    }








    // Solicitudes
    public function actualizarEstado($id, Request $request)
    {
        // Obtener la solicitud especificada por ID
        $solicitud = SolicitudViaticos::findOrFail($id);

        // Validar si el usuario ha agregado un comentario
        $comentarioUsuario = $this->validarComentarioUsuario($solicitud->FOLIO_via);

        if (!$comentarioUsuario) {
            // El usuario no ha agregado un comentario, puedes devolver un mensaje de error o tomar alguna acción
            return redirect()->back()->with('error', 'Debes agregar un comentario antes de aceptar o rechazar la solicitud.');
        }

        // Obtener el nivel del usuario autenticado
        $nivelUsuario = auth()->user()->nivel;

        // Determinar si el usuario es SuperAdmin
        $esSuperAdmin = auth()->user()->role === 'SuperAdmin';

        // Verificar que el nivel del usuario sea válido (0, 1, 2 o 3)
        if ($esSuperAdmin || ($nivelUsuario >= 1 && $nivelUsuario <= 3)) {
            // Verificar si se está aceptando o rechazando
            if ($request->estado == 'rechazar') {
                // Establecer el estado de rechazo
                $estado = 2;  // Asumiendo que 2 representa 'rechazado'
                // Actualizar el nivel a 4 en caso de rechazo
                $solicitud->nivel = 4;
                $mensaje = 'Se ha rechazado correctamente.';
            } else {
                // Establecer el estado de aceptación
                $estado = 1;  // Asumiendo que 1 representa 'aceptado'
                // Incrementar el nivel solo si no se rechaza
                if (!$esSuperAdmin || $esSuperAdmin) {
                    $solicitud->nivel = $solicitud->nivel + 1;
                }
                $mensaje = 'Se ha aceptado correctamente.';
            }

            // Actualizar los campos aceptadoNivelX dependiendo del nivel del usuario
            if ($esSuperAdmin) {
                // El SuperAdmin puede actualizar cualquier nivel
                if ($solicitud->aceptadoNivel1 == 0) {
                    $solicitud->aceptadoNivel1 = $estado;
                } elseif ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 0) {
                    $solicitud->aceptadoNivel2 = $estado;
                } elseif ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel3 == 0) {
                    $solicitud->aceptadoNivel3 = $estado;
                }
            } else {
                // Actualizar el campo correspondiente según el nivel del usuario
                switch ($nivelUsuario) {
                    case 1:
                        $solicitud->aceptadoNivel1 = $estado;
                        break;
                    case 2:
                        if ($solicitud->aceptadoNivel1 == 1) {
                            $solicitud->aceptadoNivel2 = $estado;
                        }
                        break;
                    case 3:
                        if ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 1) {
                            $solicitud->aceptadoNivel3 = $estado;
                        }
                        break;
                }
            }

            // Comprobar si todos los niveles han sido aceptados
            if ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel3 == 1) {
                $solicitud->comprobacionVisible = 1;


                // Crear una nueva notificación 
                $contenido = "Se ha aprovado tú solicitud del folio {$solicitud->FOLIO_via}, ya puedes subir la comprobación.";
                $notificacion = new Notificacion([
                    'titulo' => 'Comprobación pendiente', // Asignar un título a la notificación
                    'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
                    'leida' => false, // Asignar el siguiente nivel
                    'id_User' => $solicitud->user_id,  // Acceder al ID del usuario a través de la relación
                    'folio_via' => $solicitud->FOLIO_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
                ]);

                // Guardar la notificación
                $notificacion->save();
            }

            // Guardar los cambios en la base de datos
            $solicitud->save();

            // Obtener el nivel siguiente
            $siguienteNivel = $solicitud->nivel;

            // Eliminar las notificaciones existentes con el mismo folio de solicitud de viáticos y con un nivel definido
            Notificacion::where('folio_via', $solicitud->FOLIO_via)
                ->whereNotNull('nivel')  // Asegura que el campo 'nivel' no sea nulo
                ->delete();


            // Verificar si el siguiente nivel es menor que 4 para guardar la notificación
            if ($siguienteNivel < 4) {
                // Crear una nueva notificación 
                $contenido = "Tienes una nueva solicitud por aprobar del folio {$solicitud->FOLIO_via}";
                $notificacion = new Notificacion([
                    'titulo' => 'Nueva solicitud', // Asignar un título a la notificación
                    'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
                    'leida' => false,
                    'nivel' => $siguienteNivel, // Asignar el siguiente nivel
                    'folio_via' => $solicitud->FOLIO_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
                ]);

                // Guardar la notificación
                $notificacion->save();
            }


            return redirect()->route('autorizar')->with('success', $mensaje);
        } else {
            return redirect()->back()->with('error', 'El nivel del usuario no es válido.');
        }
    }




    public function validarComentarioUsuario($folioSoli)
    {
        // Obtenemos el ID del usuario autenticado
        $idUsuario = auth()->user()->id;

        // Buscamos si existe un comentario del usuario en la tabla comentarios_revisores
        $comentario = ComentarioRevisor::where('idRevisor', $idUsuario)
            ->where('folioSoli', $folioSoli)
            ->exists();

        return $comentario;
    }



    public function revisarAutorizacionSolicitud($id)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener la solicitud especificada por ID
        $solicitud = SolicitudViaticos::with('proyecto', 'user')->findOrFail($id);

        // Verificar si el usuario tiene permiso para ver la solicitud
        /*if ($user->role !== 'SuperAdmin' && $solicitud->revisor_id !== $user->id) {
        return redirect()->route('error.403');
    }*/

        // Filtrar los comentarios que tienen el mismo folio
        $comentarios = ComentarioRevisor::where('folioSoli', $solicitud->FOLIO_via)->get();

        // Pasar la solicitud y sus relaciones a la vista
        return view('gastos.viaticos.autorizarViatico', compact('solicitud', 'comentarios'));
    }




    //Historial de gastos:

    public function historialVer()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, mostrar todas las solicitudes y comprobaciones
        if ($user->role === 'SuperAdmin') {
            $solicitudes = SolicitudViaticos::orderBy('FOLIO_via', 'desc')->paginate(10);
            $comprobaciones = ComprobacionInfo::orderBy('folio_via', 'desc')->paginate(10);
        } else {
            // Verificar si el usuario autenticado es un revisor o no
            if ($user->revisor == '1') {  // Asumiendo que '1' significa que el usuario es revisor
                // Iniciar la consulta básica para revisores de solicitudes
                $querySolicitud = SolicitudViaticos::query();
                $queryComprobacion = ComprobacionInfo::query(); // Iniciar la consulta básica para revisores de comprobaciones

                // Aplicar filtros adicionales basados en el nivel del usuario para solicitudes y comprobaciones
                if ($user->nivel == '1') {
                    $querySolicitud->where(function ($q) {
                        $q->where('aceptadoNivel1', 1)->orWhere('aceptadoNivel1', 2);
                    });
                    $queryComprobacion->where('aceptadoNivel1', 1); // Asumiendo que solo necesitan ver comprobaciones aceptadas en Nivel 1
                } elseif ($user->nivel == '2') {
                    $querySolicitud->where(function ($q) {
                        $q->where('aceptadoNivel2', 1)->orWhere('aceptadoNivel1', 2);
                    });
                    $queryComprobacion->where(function ($q) {
                        $q->where('aceptadoNivel2', 1)->orWhere('aceptadoNivel1', 2);
                    });
                } elseif ($user->nivel == '3') {
                    $querySolicitud->where(function ($q) {
                        $q->where('aceptadoNivel2', 1)
                            ->orWhere('aceptadoNivel2', 2)
                            ->orWhere(function ($q2) {
                                $q2->where('aceptadoNivel1', 2)
                                    ->where('aceptadoNivel2', 2)
                                    ->where('aceptadoNivel3', 2);
                            });
                    });
                    $queryComprobacion->where(function ($q) {
                        $q->where('aceptadoNivel2', 1)
                            ->orWhere('aceptadoNivel2', 2)
                            ->orWhere(function ($q2) {
                                $q2->where('aceptadoNivel1', 2)
                                    ->where('aceptadoNivel2', 2)
                                    ->where('aceptadoNivel3', 2);
                            });
                    });
                }
                $solicitudes = $querySolicitud->orderBy('FOLIO_via', 'desc')->paginate(10);
                $comprobaciones = $queryComprobacion->orderBy('folio_via', 'desc')->paginate(10);
            } else {
                // Para usuarios que no son revisores, mostrar solo sus propias solicitudes y comprobaciones
                $solicitudes = SolicitudViaticos::where('user_id', $user->id)->orderBy('FOLIO_via', 'desc')->paginate(10);

                // Obtener los folios de las solicitudes que pertenecen al usuario
                $folios = SolicitudViaticos::where('user_id', $user->id)->pluck('FOLIO_via');

                // Filtrar las comprobaciones que están relacionadas con esos folios
                $comprobaciones = ComprobacionInfo::whereIn('folio_via', $folios)->orderBy('folio_via', 'desc')->paginate(10);
            }
        }

        // Pasar las solicitudes y comprobaciones filtradas a la vista
        return view('gastos.viaticos.historial.historial', compact('solicitudes', 'comprobaciones'));
    }



    public function historialSolicitud($id)
    {
        // Obtener todas las solicitudes ordenadas por FOLIO_via de manera descendente y paginadas
        $solicitud = SolicitudViaticos::find($id);

        // Filtrar los comentarios que tienen el mismo folio
        $comentarios = ComentarioRevisor::where('folioSoli', $solicitud->FOLIO_via)->get();

        // Pasar las solicitudes filtradas a la vista
        return view('gastos.viaticos.historial.historial-solicitud', compact('solicitud', 'comentarios'));
    }
}
