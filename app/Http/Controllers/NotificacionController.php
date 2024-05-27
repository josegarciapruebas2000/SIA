<?php

namespace App\Http\Controllers;
use App\Models\Notificacion;


use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function marcarComoLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->leida = true;
        $notificacion->save();

        return redirect()->back()->with('success', 'Notificación marcada como leída.');
    }
}
