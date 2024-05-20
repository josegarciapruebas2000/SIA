<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use App\Models\SolicitudViaticos;
use App\Models\ComentarioRevisor;


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

        // Redirigir al dashboard con el mensaje de éxito
        return redirect()->route('dashboard')->with(['showConfirmationModal' => true, 'success' => '¡Tu solicitud ha sido enviada con éxito!']);
    }


    public function autorizarVerSolicitudes()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si el usuario es SuperAdmin, obtener todas las solicitudes
        if ($user->role === 'SuperAdmin') {
            $solicitudes = SolicitudViaticos::with('proyecto')->get();
        } else {
            // Obtener el nivel del usuario autenticado
            $nivelUsuario = $user->nivel;

            // Obtener las solicitudes de viáticos asociadas al nivel del usuario autenticado
            $solicitudes = SolicitudViaticos::where('nivel', $nivelUsuario)
                ->with('proyecto')
                ->get();
        }

        // Calcular la suma de total_via
        $totalSum = $solicitudes->sum('total_via');

        // Pasar las solicitudes y la suma total a la vista
        return view('gastos.viaticos.autorizar', compact('solicitudes', 'totalSum'));
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

    public function actualizarEstado($id, Request $request)
    {
        // Obtener la solicitud especificada por ID
        $solicitud = SolicitudViaticos::findOrFail($id);

        // Obtener el nivel del usuario autenticado
        $nivelUsuario = Auth::user()->nivel;

        // Verificar que el nivel del usuario sea válido (1, 2 o 3)
        if ($nivelUsuario >= 1 && $nivelUsuario <= 3) {
            // Verificar si se está aceptando o rechazando
            $estado = $request->estado == 'aceptar' ? 1 : 2;

            // Actualizar el campo correspondiente según el nivel del usuario
            switch ($nivelUsuario) {
                case 1:
                    $solicitud->aceptadoNivel1 = $estado;
                    break;
                case 2:
                    $solicitud->aceptadoNivel2 = $estado;
                    break;
                case 3:
                    $solicitud->aceptadoNivel3 = $estado;
                    break;
            }

            // Incrementar el nivel
            $solicitud->nivel = $solicitud->nivel + 1;

            // Guardar los cambios en la base de datos
            $solicitud->save();

            return redirect()->back()->with('success', 'El estado se actualizó correctamente.');
        } else {
            return redirect()->back()->with('error', 'El nivel del usuario no es válido.');
        }
    }
}
