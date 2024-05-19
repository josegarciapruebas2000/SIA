<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use App\Models\SolicitudViaticos;

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

        // Guardar la solicitud en la base de datos
        $solicitud = new SolicitudViaticos();
        $solicitud->nombreSolicitud = $request->input('solicitud');
        $solicitud->idProy_via = $request->input('proyecto');
        $solicitud->comentario_via = $request->input('comentario');
        $solicitud->solicitudfecha_via = $request->input('fecha_inicio');
        $solicitud->solFinalFecha_via = $request->input('fecha_fin');
        $solicitud->revisor_id = $request->input('revisor');
        $solicitud->total_via = $request->input('total_via'); // Asignar el valor del campo total_via
        $solicitud->user_id = $user_id; // Asignar el ID del usuario autenticado
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
            // Obtener las solicitudes de viáticos asociadas al usuario autenticado como revisor
            $solicitudes = SolicitudViaticos::with('proyecto')
                ->where('revisor_id', $user->id)
                ->get();
        }

        // Pasar las solicitudes a la vista
        return view('gastos.viaticos.autorizar', compact('solicitudes'));
    }
}
