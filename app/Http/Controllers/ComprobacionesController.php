<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SolicitudViaticos;
use App\Models\ComprobacionInfo;
use App\Models\ComprobacionDocumento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Notificacion;
use App\Models\ComentarioRevisor;

class ComprobacionesController extends Controller
{
    public function listaComprobaciones()
    {
        $usuarioActual = auth()->user(); // Obtener el usuario autenticado

        // Iniciar la consulta
        $query = SolicitudViaticos::where('comprobacionVisible', 1);

        // Agregar condiciones adicionales solo si el usuario no es SuperAdmin
        if ($usuarioActual->role !== 'SuperAdmin') {
            $query->where('user_id', $usuarioActual->id);
        }

        // Ejecutar la consulta
        $comprobaciones = $query->get();

        return view('gastos.viaticos.comprobaciones', compact('comprobaciones'));
    }



    public function verComprobacion($id)
    {
        $comprobacion = SolicitudViaticos::find($id);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, obtener todos los revisores
        if ($user->role === 'SuperAdmin') {
            $revisores = User::where('revisor', '1')->where('status', 1)->get();
        } else {
            // Determinar el nivel de revisores a mostrar basado en el nivel del usuario autenticado
            $nivelRevisor = $user->nivel + 1;

            // Obtener los revisores activos según el nivel del usuario autenticado
            $revisores = User::where('revisor', '1')
                ->where('status', 1)
                ->where('nivel', $nivelRevisor)
                ->get();
        }

        return view('gastos.viaticos.comprobacion', compact('comprobacion', 'revisores'));
    }


    public function solicitud()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, obtener todos los revisores
        if ($user->role === 'SuperAdmin') {
            $revisores = User::where('revisor', '1')->where('status', 1)->get();
        } else {
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

    public function store(Request $request, $id)
{
    try {
        // Obtener id del revisor
        $revisorId = $request->input('revisor_id');

        // Obtener el monto comprobado del campo en el formulario
        $montoComprobado = floatval(str_replace('$', '', $request->input('monto_comprobado')));

        // Buscar el usuario en la tabla de Users y obtener su nivel
        $revisor = User::find($revisorId);
        if (!$revisor) {
            return response()->json(['error' => 'Revisor no encontrado'], 404);
        }
        $nivelRevisor = $revisor->nivel;

        // Crear una nueva instancia de ComprobacionInfo y asignar valores
        $comprobacion = new ComprobacionInfo();
        $comprobacion->folio_via = $id;
        $comprobacion->monto_comprobado = $montoComprobado;
        $comprobacion->nivel = $nivelRevisor;
        $comprobacion->fechaComprobacion = now();  // Guardar fecha y hora actual

        // Ajustar los valores de aceptadoNivel1, aceptadoNivel2, y aceptadoNivel3 según el nivel del revisor
        if ($nivelRevisor == 1) {
            $comprobacion->aceptadoNivel1 = 0;
            $comprobacion->aceptadoNivel2 = 0;
            $comprobacion->aceptadoNivel3 = 0;
        } elseif ($nivelRevisor == 2) {
            $comprobacion->aceptadoNivel1 = 1;
            $comprobacion->aceptadoNivel2 = 0;
            $comprobacion->aceptadoNivel3 = 0;
        } elseif ($nivelRevisor == 3) {
            $comprobacion->aceptadoNivel1 = 1;
            $comprobacion->aceptadoNivel2 = 1;
            $comprobacion->aceptadoNivel3 = 0;
        }

        $comprobacion->save();

        $solicitud = SolicitudViaticos::findOrFail($id);
        $solicitud->comprobacionVisible = 0;
        $solicitud->save();

        // Crear una nueva notificación 
        $contenido = "Tienes una nueva comprobación por aprobar del folio {$comprobacion->folio_via}";
        $notificacion = new Notificacion([
            'titulo' => 'Nueva comprobación', // Asignar un título a la notificación
            'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
            'leida' => false,
            'nivel' => $nivelRevisor, // Asignar el siguiente nivel
            'folio_via' => $comprobacion->folio_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
        ]);

        // Guardar la notificación
        $notificacion->save();

        // Guardar documentos asociados
        foreach ($request->documentos as $index => $documento) {
            $xmlFile = $request->file("documentos.$index.xml");
            $pdfFile = $request->file("documentos.$index.pdf");

            $xmlName = $xmlFile->getClientOriginalName();
            $pdfName = $pdfFile->getClientOriginalName();

            $xmlPath = $xmlFile->storeAs('xmls', $xmlName, 'public');
            $pdfPath = $pdfFile->storeAs('pdfs', $pdfName, 'public');

            ComprobacionDocumento::create([
                'idComprobacion' => $comprobacion->idComprobacion, // Usar el ID de la comprobación creada
                'fecha_subida' => $documento['fecha_subida'],
                'descripcion' => $documento['descripcion'],
                'N_factura' => $documento['N_factura'],
                'subtotal' => $documento['subtotal'],
                'iva' => $documento['iva'],
                'total' => $documento['total'],
                'xml_path' => $xmlPath,
                'pdf_path' => $pdfPath,
                'original_xml_name' => $xmlName,
                'original_pdf_name' => $pdfName,
            ]);
        }

        // Eliminar las notificaciones existentes con el mismo folio y el mismo id del usuario
        Notificacion::where('folio_via', $solicitud->FOLIO_via)
            ->where('id_User', $solicitud->user_id)  // Asegurar que solo se eliminen las del usuario autenticado
            ->delete();

        return response()->json(['message' => 'Documentos guardados con éxito.'], 201);
    } catch (\Exception $e) {
        Log::error('Error al guardar los documentos: ' . $e->getMessage());
        return response()->json(['error' => 'Ocurrió un error al guardar los documentos: ' . $e->getMessage()], 500);
    }
}







    public function revisarAutorizacionComprobacion($id)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener la solicitud especificada por ID
        $solicitud = SolicitudViaticos::with('proyecto', 'user')->findOrFail($id);

        // Obtener la comprobación relacionada con la solicitud
        $comprobacionInfo = ComprobacionInfo::where('folio_via', $solicitud->FOLIO_via)->firstOrFail();

        // Obtener los documentos relacionados con la comprobación
        $facturas = $comprobacionInfo->documentos;

        // Verificar si el usuario tiene permiso para ver la solicitud
        /*if ($user->role !== 'SuperAdmin' && $solicitud->revisor_id !== $user->id) {
        return redirect()->route('error.403');
    }*/

        // Filtrar los comentarios que tienen el mismo folio de comprobacion
        $comentariosComprobaciones = ComentarioRevisor::with('revisor')
            ->where('folioComprobacion', $comprobacionInfo->idComprobacion)
            ->get();

        // Pasar la solicitud, comprobación y documentos a la vista
        return view('gastos.viaticos.autorizarComprobacion', compact('solicitud', 'comentariosComprobaciones', 'comprobacionInfo', 'facturas'));
    }


    public function actualizarEstadoComprobacion($id, Request $request)
    {
        // Obtener la solicitud especificada por ID
        $comprobacion = ComprobacionInfo::findOrFail($id);

        // Validar si el usuario ha agregado un comentario
        $comentarioUsuario = $this->validarComentarioUsuarioComprobacion($comprobacion->idComprobacion);

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
                $comprobacion->nivel = 4;
                $mensaje = 'Se ha rechazado correctamente.';
            } else {
                // Establecer el estado de aceptación
                $estado = 1;  // Asumiendo que 1 representa 'aceptado'
                // Incrementar el nivel solo si no se rechaza
                if (!$esSuperAdmin || $esSuperAdmin) {
                    $comprobacion->nivel = $comprobacion->nivel + 1;
                }
                $mensaje = 'Se ha aceptado correctamente.';
            }

            // Actualizar los campos aceptadoNivelX dependiendo del nivel del usuario
            if ($esSuperAdmin) {
                // El SuperAdmin puede actualizar cualquier nivel
                if ($comprobacion->aceptadoNivel1 == 0) {
                    $comprobacion->aceptadoNivel1 = $estado;
                } elseif ($comprobacion->aceptadoNivel1 == 1 && $comprobacion->aceptadoNivel2 == 0) {
                    $comprobacion->aceptadoNivel2 = $estado;
                } elseif ($comprobacion->aceptadoNivel1 == 1 && $comprobacion->aceptadoNivel2 == 1 && $comprobacion->aceptadoNivel3 == 0) {
                    $comprobacion->aceptadoNivel3 = $estado;
                }
            } else {
                // Actualizar el campo correspondiente según el nivel del usuario
                switch ($nivelUsuario) {
                    case 1:
                        $comprobacion->aceptadoNivel1 = $estado;
                        break;
                    case 2:
                        if ($comprobacion->aceptadoNivel1 == 1) {
                            $comprobacion->aceptadoNivel2 = $estado;
                        }
                        break;
                    case 3:
                        if ($comprobacion->aceptadoNivel1 == 1 && $comprobacion->aceptadoNivel2 == 1) {
                            $comprobacion->aceptadoNivel3 = $estado;
                        }
                        break;
                }
            }

            // Comprobar si todos los niveles han sido aceptados
            if ($comprobacion->aceptadoNivel1 == 1 && $comprobacion->aceptadoNivel2 == 1 && $comprobacion->aceptadoNivel3 == 1) {


                // Crear una nueva notificación 
                $contenido = "Se ha aprovado tú comprobación del folio {$comprobacion->folio_via}.";
                $notificacion = new Notificacion([
                    'titulo' => 'Comprobación aceptada', // Asignar un título a la notificación
                    'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
                    'leida' => false, // Asignar el siguiente nivel
                    'id_User' => $comprobacion->user_id,  // Acceder al ID del usuario a través de la relación
                    'folio_via' => $comprobacion->folio_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
                ]);

                // Guardar la notificación
                $notificacion->save();
            }

            // Guardar los cambios en la base de datos
            $comprobacion->save();

            // Obtener el nivel siguiente
            $siguienteNivel = $comprobacion->nivel;

            // Eliminar las notificaciones existentes con el mismo folio de solicitud de viáticos y con un nivel definido
            Notificacion::where('folio_via', $comprobacion->folio_via)
                ->whereNotNull('nivel')  // Asegura que el campo 'nivel' no sea nulo
                ->delete();


            // Verificar si el siguiente nivel es menor que 4 para guardar la notificación
            if ($siguienteNivel < 4) {
                // Crear una nueva notificación 
                $contenido = "Tienes una nueva comprobación por aprobar del folio {$comprobacion->folio_via}";
                $notificacion = new Notificacion([
                    'titulo' => 'Nueva comprobación', // Asignar un título a la notificación
                    'mensaje' => $contenido, // Asignar el contenido como el mensaje de la notificación
                    'leida' => false,
                    'nivel' => $siguienteNivel, // Asignar el siguiente nivel
                    'folio_via' => $comprobacion->folio_via, // Asignar el valor de FOLIO_via de la solicitud de viáticos
                ]);

                // Guardar la notificación
                $notificacion->save();
            }


            // Suponiendo que 'autorizar' es el nombre de tu ruta
            return redirect()->route('autorizar', ['tab' => 'comprobacion'])->with('success', $mensaje);
        } else {
            return redirect()->back()->with('error', 'El nivel del usuario no es válido.');
        }
    }




    public function validarComentarioUsuarioComprobacion($folioComprobacion)
    {
        // Obtenemos el ID del usuario autenticado
        $idUsuario = auth()->user()->id;

        // Buscamos si existe un comentario del usuario en la tabla comentarios_revisores
        $comentario = ComentarioRevisor::where('idRevisor', $idUsuario)
            ->where('folioComprobacion', $folioComprobacion)
            ->exists();

        return $comentario;
    }


    public function historialComprobacion($id)
    {
        // Obtener la comprobación o fallar con una excepción que Laravel manejará como un error 404
        $comprobacion = ComprobacionInfo::findOrFail($id);

        // Obtener comentarios y facturas relacionados con la comprobación
        $comentarios = ComentarioRevisor::where('folioComprobacion', $comprobacion->idComprobacion)->get();
        $facturas = ComprobacionDocumento::where('idComprobacion', $comprobacion->idComprobacion)->get();

        // Pasar las solicitudes filtradas a la vista
        return view('gastos.viaticos.historial.historial-comprobacion', compact('comprobacion', 'comentarios', 'facturas'));
    }

    public function verComprobacionGasto($id)
    {
        $user = Auth::user();

        // Obtener la información de comprobacion junto con sus documentos relacionados
        $comprobacion = ComprobacionInfo::with('documentos')->find($id);

        if (!$comprobacion) {
            return redirect()->back()->with('error', 'Comprobación no encontrada');
        }

        // Calcular los totales
        $totalSubtotal = $comprobacion->documentos->sum('subtotal');
        $totalIva = $comprobacion->documentos->sum('iva');
        $totalTotal = $comprobacion->documentos->sum('total');
        $totalComprobado = $comprobacion->monto_comprobado;
        $totalAComprobar = $comprobacion->solicitudviatico->total_via;
        $diferencia = $totalComprobado - $totalAComprobar;

        $aFavor = $diferencia > 0 ? 'Beneficiario' : 'Empresa';

        return view('gastos.viaticos.historial.comprobacionGasto', compact('comprobacion', 'user', 'totalSubtotal', 'totalIva', 'totalTotal', 'totalComprobado', 'totalAComprobar', 'diferencia', 'aFavor'));
    }
}
