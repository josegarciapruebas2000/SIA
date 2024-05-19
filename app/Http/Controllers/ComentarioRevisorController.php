<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComentarioRevisor;
use Carbon\Carbon;


class ComentarioRevisorController extends Controller
{
    public function agregarComentarioRevisor(Request $request)
    {
        // Debugging: Verifica los datos recibidos
        //dd($request->all());

        // Crear un nuevo comentario de revisor
        $comentario = new ComentarioRevisor();
        $comentario->idRevisor = $request->input('idRevisor');
        $comentario->folioSoli = $request->input('folioSoli');
        $comentario->comentario = $request->input('comentario');
        $comentario->fecha_hora = Carbon::now(); // Guardar la fecha y hora actual
        $comentario->save();

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Comentario agregado exitosamente.');
    }

    
}
