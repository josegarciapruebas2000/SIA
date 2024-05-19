<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNivel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $nivelRequired
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $nivelRequired)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirige al usuario al inicio de sesión si no está autenticado
        }

        // Obtener el nivel del usuario autenticado
        $nivelUsuario = auth()->user()->nivel;

        // Verificar si el nivel del usuario cumple con el nivel requerido
        if ($nivelUsuario >= $nivelRequired) {
            return $next($request); // Permitir el acceso a la solicitud
        }

        // Redirigir al usuario a una página de error o a la página principal
        return redirect()->route('error.403'); // Puedes personalizar la ruta según tus necesidades
    }
}
