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

class ComprobacionesController extends Controller
{
    public function listaComprobaciones()
    {
        // Filtrar las solicitudes donde aceptadoNivel1, aceptadoNivel2 y aceptadoNivel3 son 1
        $comprobaciones = SolicitudViaticos::where('aceptadoNivel1', 1)
            ->where('aceptadoNivel2', 1)
            ->where('aceptadoNivel3', 1)
            ->get();

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

        // Verificar si el usuario tiene permiso para ver la solicitud
        /*if ($user->role !== 'SuperAdmin' && $solicitud->revisor_id !== $user->id) {
        return redirect()->route('error.403');
    }*/

        // Filtrar los comentarios que tienen el mismo folio
        //$comentarios = ComentarioRevisor::where('folioSoli', $solicitud->FOLIO_via)->get();

        // Pasar la solicitud y sus relaciones a la vista
        //return view('gastos.viaticos.autorizarViatico', compact('solicitud', 'comentarios'));
        return view('gastos.viaticos.autorizarComprobacion', compact('solicitud'));

    }


}
