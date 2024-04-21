<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Usuarios extends Controller
{
    public function listaUsuarios()
    {
        // Obtener el ID del usuario que inició sesión
        $userId = Auth::id();

        // Obtener la lista de usuarios excluyendo al usuario que inició sesión
        $users = User::where('id', '!=', $userId)->paginate(10);

        // Pasar la lista de usuarios a la vista
        return view('dashboard.usuarios', compact('users'));
    }


    public function guardar(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // No necesitas la confirmación aquí
            'role' => 'required|string',
        ]);

        // Crear un nuevo usuario
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // Determinar el estado
        $estado = $request->has('estado') ? 1 : 0;
        $user->password = Hash::make($request->input('password')); // Utiliza Hash::make para cifrar la contraseña
        $user->role = $request->input('role');
        $user->status = $estado; // Asignar el estado como un número (1 para Habilitado, 0 para Deshabilitado)
        $user->save();

        // Redirigir a alguna vista o ruta después de guardar el usuario
        return redirect()->route('usuarios.lista')->with('success', 'Usuario creado exitosamente');
    }

    public function toggleUsuario($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = !$user->status;
            $user->save();
        }
        return redirect()->route('usuarios.lista')->with('success', 'Estado del usuario actualizado exitosamente');
    }

    public function eliminarUsuario($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('usuarios.lista')->with('success', 'Usuario eliminado exitosamente');
    }

    public function editarUsuario($id)
    {
        // Obtener el usuario a editar por su ID
        $usuario = User::find($id);

        // Pasar el usuario a la vista del formulario de edición
        return view('dashboard.editarUsuario', compact('usuario'));
    }


    public function update(Request $request, $id)
    {
        // Encuentra el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualiza los campos del usuario con los datos del formulario
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->role = $request->input('role');
        // Verifica si el checkbox de estado está marcado y actualiza el estado del usuario en consecuencia
        $usuario->status = $request->has('status') ? 1 : 0;

        $usuario->password = bcrypt($request->input('password'));

        // Guarda los cambios en la base de datos
        $usuario->save();

        // Redirecciona a alguna página después de guardar los cambios
        return redirect()->route('usuarios.lista')->with('success', 'Usuario actualizado correctamente.');
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        // Validar los campos que pueden ser actualizados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // La contraseña debe ser confirmada
        ]);

        // Actualizar los campos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Si la contraseña no está en blanco, actualízala; de lo contrario, conserva la contraseña anterior
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Guardar los cambios en la base de datos
        $user->save();

        // Redireccionar a alguna página después de guardar los cambios
        return redirect()->route('login')->with('success', 'Perfil actualizado correctamente.');
    }
}
