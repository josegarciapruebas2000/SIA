<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Usuarios extends Controller
{
    public function listaUsuarios()
    {
        $users = User::paginate(10); // Obtener usuarios paginados con 10 usuarios por página
        return view('dashboard.usuarios', compact('users'));
    }

    public function guardar(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8', // No necesitas la confirmación aquí
        'rol' => 'required|string',
    ]);

    // Determinar el estado
    $estado = $request->has('estado') ? 1 : 0;

    // Crear un nuevo usuario
    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = bcrypt($request->input('password'));
    $user->role = $request->input('rol');
    $user->status = $estado; // Asignar el estado como un número (1 para Habilitado, 0 para Deshabilitado)
    $user->save();

    // Redirigir a alguna vista o ruta después de guardar el usuario
    return redirect()->route('usuarios.lista')->with('success', 'Usuario creado exitosamente');
}

}
