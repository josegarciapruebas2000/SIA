<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('error.403'); // Redirige a la página de error 403 si el usuario no ha iniciado sesión
        }

        foreach ($roles as $role) {
            if (auth()->user()->role === $role) {
                return $next($request);
            }
        }

        return redirect()->route('error.403'); // Redirige a la página de error 403 si el usuario no tiene ninguno de los roles especificados
    }
}
