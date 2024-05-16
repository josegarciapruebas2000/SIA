<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Usuarios extends Controller
{
    public function listaUsuarios(Request $request)
    {
        // Obtener el ID del usuario que inició sesión
        $userId = Auth::id();

        // Obtener el término de búsqueda del formulario
        $searchTerm = $request->input('search');

        // Obtener el filtro seleccionado
        $filter = $request->input('filter');

        // Consulta de búsqueda con cláusula OR para buscar en múltiples columnas
        $users = User::where('id', '!=', $userId)
            ->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', "%$searchTerm%")
                    ->orWhere('name', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%");
            });

        // Aplicar filtro según la opción seleccionada
        if ($filter == 'activos') {
            $users->where('status', 1);
        } elseif ($filter == 'inactivos') {
            $users->where('status', 0);
        } elseif ($filter == 'revisores') {
            $users->where('revisor', 1);
        }

        $users = $users->orderBy('id', 'desc')->paginate(5);

        // Pasar la lista de usuarios a la vista
        return view('dashboard.usuarios.usuarios', compact('users'));
    }




    public function guardar(Request $request)
    {
        // Define los mensajes de error personalizados
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'role.required' => 'El campo rol es obligatorio.',
        ];

        // Validar los datos del formulario con los mensajes personalizados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ], $messages);

        // Verificar si el correo electrónico está vacío
        if (empty($request->input('email'))) {
            return back()->withInput()->withErrors(['email' => 'El correo electrónico es obligatorio.']);
        }

        // Verificar si el correo electrónico ya existe
        if (User::where('email', $request->input('email'))->exists()) {
            return back()->withInput()->withErrors(['email' => 'El correo electrónico ya está registrado.']);
        }

        // Crear un nuevo usuario
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // Determinar el estado
        $estado = $request->has('estado') ? 1 : 0;
        $user->status = $estado;

        // Determinar si es revisor
        $revisor = $request->has('revisorSwitch') ? 1 : 0;

        // Si el valor de revisor no se recibe en la solicitud, establecerlo en 0
        if ($revisor === 0) {
            $revisor = 0;
        }

        $user->revisor = $revisor;

        // Determinar el nivel
        $nivel = $request->filled('nivel') ? $request->input('nivel') : 0;

        $user->nivel = $nivel;

        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
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
    }


    public function eliminarUsuario($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('usuarios.lista')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->route('usuarios.lista')->with('error', 'No se pudo encontrar el usuario');
        }
    }




    public function editarUsuario($id)
    {
        // Obtener el usuario a editar por su ID
        $usuario = User::find($id);

        // Pasar el usuario a la vista del formulario de edición
        return view('dashboard.usuarios.editarUsuario', compact('usuario'));
    }


    public function update(Request $request, $id)
    {
        // Encuentra el usuario por su ID
        $usuario = User::findOrFail($id);

        // Imprime los datos recibidos del formulario para depuración
        //dd($request->all());

        // Valida los campos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8',
        ], [
            'email.unique' => 'El correo electrónico ya está registrado por otro usuario.',
        ]);

        // Actualiza los campos del usuario con los datos del formulario
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->role = $request->input('role');

        // Si el estado no se recibe en la solicitud, establecerlo en 0
        $usuario->status = $request->has('status') ? $request->input('status') : 0;

        // Si el revisor no se recibe en la solicitud, establecerlo en 0
        $usuario->revisor = $request->has('revisorSwitch') ? $request->input('revisorSwitch') : 0;

        // Si se proporciona una nueva contraseña, cámbiala
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }

        $usuario->nivel = $request->input('nivel') ?? 0;

        // Guarda los cambios en la base de datos
        $usuario->save();

        // Redirige a alguna página después de guardar los cambios
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
