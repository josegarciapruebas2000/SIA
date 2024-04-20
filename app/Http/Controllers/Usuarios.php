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
            'password' => 'required|string|min:8|confirmed', // Utiliza el campo 'password' en lugar de 'password_confirmation'
            'rol' => 'required|string',
        ]);

        // Crear un nuevo usuario
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Obtén la contraseña del campo 'password'
        $user->role = $request->input('rol'); // Ajusta el nombre del campo al que estás usando en el formulario
        $user->status = $request->has('flexSwitchCheckDefault') ? 'Habilitado' : 'Deshabilitado'; // Ajusta el nombre del campo del estado
        $user->save();

        // Redirigir a alguna vista o ruta después de guardar el usuario
        return redirect()->route('dashboard.usuarios')->with('success', 'Usuario creado exitosamente');
    }
}
