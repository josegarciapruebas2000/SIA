<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function solicitud()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los proyectos asociados al usuario autenticado
        $proyectos = Proyecto::whereHas('usuarios', function ($query) use ($user) {
            $query->where('idUsuario', $user->id);
        })->where('status', 1)->get();

        // Obtener los revisores activos
        $revisores = User::where('revisor', '1')->where('status', 1)->get();


        return view('gastos.viaticos.solicitud', compact('proyectos', 'revisores'));
    }
}
