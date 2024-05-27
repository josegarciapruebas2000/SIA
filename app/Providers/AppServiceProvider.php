<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $notificaciones = null;

            // Verificar si hay un usuario autenticado
            if (Auth::check()) {
                // Obtener el usuario autenticado
                $user = Auth::user();

                // Verificar el nivel del usuario y obtener las notificaciones si es necesario
                if (in_array($user->nivel, [1, 2, 3])) {
                    $notificaciones = Notificacion::where('nivel', $user->nivel)
                        ->where('leida', false)
                        ->get();
                    Log::info('Notificaciones cargadas: ', $notificaciones->toArray()); // Línea de depuración
                } else {
                    Log::info('El usuario no tiene un nivel válido para recibir notificaciones');
                }
            } else {
                Log::info('No hay usuario autenticado');
            }

            // Compartir las notificaciones con todas las vistas
            $view->with('notificaciones', $notificaciones);
        });
    }
}
