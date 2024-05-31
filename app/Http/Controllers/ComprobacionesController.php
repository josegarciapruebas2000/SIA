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
            // Obtener el monto comprobado del campo en el formulario
            $montoComprobado = floatval(str_replace('$', '', $request->input('monto_comprobado')));

            // Obtener el nivel del revisor
            $nivel = $request->input('nivel');

            // Crear una nueva instancia de ComprobacionInfo y asignar valores
            $comprobacion = new ComprobacionInfo();
            $comprobacion->folio_via = $id;
            $comprobacion->monto_comprobado = $montoComprobado;
            $comprobacion->nivel = $nivel - 1;
            $comprobacion->aceptadoNivel1 = 0;
            $comprobacion->aceptadoNivel2 = 0;
            $comprobacion->aceptadoNivel3 = 0;
            $comprobacion->save();

            $solicitud = SolicitudViaticos::findOrFail($id);
            $solicitud->comprobacionVisible = 0;
            $solicitud->save();

            // Verificar si el ID de comprobacion se asignó correctamente
            if (is_null($comprobacion->idComprobacion)) {
                Log::error('El ID de comprobacion es nulo después de guardar.');
                throw new \Exception('El ID de comprobacion es nulo después de guardar.');
            }

            Log::info('ID de Comprobacion generado: ' . $comprobacion->idComprobacion);

            // Guardar documentos asociados
            foreach ($request->documentos as $index => $documento) {
                $xmlPath = $request->hasFile("documentos.$index.xml") ? $request->file("documentos.$index.xml")->store('xmls', 'public') : null;
                $pdfPath = $request->hasFile("documentos.$index.pdf") ? $request->file("documentos.$index.pdf")->store('pdfs', 'public') : null;

                Log::info('Guardando documento ' . $index);

                ComprobacionDocumento::create([
                    'idComprobacion' => $comprobacion->idComprobacion, // Usar el ID de la comprobación creada
                    'fecha_subida' => $documento['fecha_subida'],
                    'descripcion' => $documento['descripcion'],
                    'N_factura' => $documento['N_factura'],
                    'subtotal' => $documento['subtotal'],
                    'iva' => $documento['iva'],
                    'total' => $documento['total'],
                    'xml_path' => $xmlPath,
                    'pdf_path' => $pdfPath
                ]);
            }

            // Obtener el ID del usuario autenticado
            $userId = Auth::id();

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
}
