<?php

namespace App\Http\Controllers;
use App\Models\User; // Asegúrate de importar el modelo User

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function listaUsuarios()
{
    $users = User::paginate(10); // Obtener usuarios paginados con 10 usuarios por página
    return view('dashboard.usuarios', compact('users'));
}

}
