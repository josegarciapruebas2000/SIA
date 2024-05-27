<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SolicitudViaticos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        return view('gastos.viaticos.comprobacion', compact('comprobacion','revisores'));
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
}
