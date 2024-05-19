<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNivelOrRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$rolesOrNiveles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$rolesOrNiveles)
    {
        if (!auth()->check()) {
            return redirect()->route('error.403'); // Redirige a la página de error 403 si el usuario no ha iniciado sesión
        }

        $user = auth()->user();
        $niveles = array_slice($rolesOrNiveles, 0, count($rolesOrNiveles) - 1); // Todos menos el último elemento
        $role = $rolesOrNiveles[count($rolesOrNiveles) - 1]; // El último elemento

        // Verifica si el nivel del usuario está en los niveles permitidos o si el rol del usuario es el rol permitido
        if (in_array($user->nivel, $niveles) || $user->role === $role) {
            return $next($request);
        }

        return redirect()->route('error.403'); // Redirige a la página de error 403 si el usuario no tiene ninguno de los roles o niveles especificados
    }
}
