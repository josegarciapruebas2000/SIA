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
        $notificaciones = collect(); // Utilizar una colección para combinar posibles múltiples conjuntos de resultados

        // Verificar si hay un usuario autenticado
        if (Auth::check()) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Obtener notificaciones dirigidas específicamente al usuario por id_User
            $notificacionesUsuario = Notificacion::where('id_User', $user->id)
                                                 ->where('leida', false)
                                                 ->get();

            // Verificar el nivel del usuario y obtener las notificaciones por nivel, si aplica
            if (in_array($user->nivel, [1, 2, 3])) {
                $notificacionesNivel = Notificacion::where('nivel', $user->nivel)
                                                   ->whereNull('id_User') // Asegurarse de que id_User sea nulo
                                                   ->where('leida', false)
                                                   ->get();
                // Combinar notificaciones de nivel con las específicas del usuario
                $notificaciones = $notificacionesUsuario->merge($notificacionesNivel);
            } else {
                // Si no hay notificaciones de nivel válidas, usar solo las específicas del usuario
                $notificaciones = $notificacionesUsuario;
            }

            Log::info('Notificaciones cargadas para el usuario: ', ['user_id' => $user->id, 'notificaciones' => $notificaciones->toArray()]);
        } else {
            Log::info('No hay usuario autenticado');
        }

        // Compartir las notificaciones con todas las vistas
        $view->with('notificaciones', $notificaciones);
    });
}

}
