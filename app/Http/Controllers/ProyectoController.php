<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoUsuario;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProyectoController extends Controller
{
    public function listaProyectos(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $search = $request->input('search');

        // Consulta inicial para obtener todos los clientes activos
        $clientesActivos = Cliente::where('status', 1)->pluck('idCliente');

        // Consulta inicial para obtener todos los proyectos
        $query = Proyecto::query();

        // Aplicar filtros si se proporciona un término de búsqueda
        if ($search) {
            $query->where('idProy', 'LIKE', '%' . $search . '%')
                ->orWhere('nombreProy', 'LIKE', '%' . $search . '%')
                ->orWhere('idClienteProy', 'LIKE', '%' . $search . '%');
        }

        // Aplicar filtro para mostrar solo proyectos con clientes activos
        $query->whereIn('idClienteProy', $clientesActivos);

        // Obtener los proyectos filtrados y paginados
        $proyectos = $query->orderBy('idProy', 'desc')->paginate(5);

        // Obtener todos los clientes disponibles
        $clientes = Cliente::all();

        // Obtener solo los usuarios que no tengan el rol de SuperAdmin y con status 1
        $usuarios = User::where('status', 1)
            ->where('role', '!=', 'SuperAdmin')
            ->get();

        //Obtener lista de la tabla pivote proyecto_usuario
        $pivotes = ProyectoUsuario::all();


        // Pasar los proyectos y clientes a la vista
        return view('dashboard.proyectos.proyectos', compact('proyectos', 'clientes', 'usuarios', 'pivotes'));
    }


    public function agregarProyecto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'moneda' => 'required|string|max:3',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio', // Validar que la fecha de fin sea posterior o igual a la fecha de inicio
            'idCliente' => 'required|exists:clientes,idCliente', // Validar que el ID del cliente exista en la tabla clientes
            'usuarios' => 'required|array', // Asegúrate de que el campo usuarios sea un array
            'usuarios.*' => 'exists:users,id', // Validar que cada usuario seleccionado exista en la tabla users
        ]);

        // Crear el proyecto y guardar el ID del cliente
        $proyecto = new Proyecto;
        $proyecto->nombreProy = $request->input('nombre');
        $proyecto->montoProy = $request->input('monto');
        $proyecto->monedaProy = $request->input('moneda');
        $proyecto->fechaInicio = $request->input('fecha_inicio'); // Guardar la fecha de inicio
        $proyecto->fechaFin = $request->input('fecha_fin'); // Guardar la fecha de fin
        $proyecto->idClienteProy = $request->input('idCliente'); // Guardar el ID del cliente
        $proyecto->status = 1;

        $proyecto->save();

        // Guardar los usuarios seleccionados en la tabla proyecto_usuario
        foreach ($request->input('usuarios') as $usuarioId) {
            $proyecto->usuarios()->attach($usuarioId);
        }

        return redirect()->route('proyectos.lista')->with('success', 'Proyecto agregado exitosamente');
    }



    public function editarProyecto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'moneda' => 'required|string|max:255',
            'idCliente' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $proyecto = Proyecto::findOrFail($id);

        $proyecto->nombreProy = $request->input('nombre');
        $proyecto->montoProy = $request->input('monto');
        $proyecto->monedaProy = $request->input('moneda');
        $proyecto->fechaInicio = $request->input('fecha_inicio');
        $proyecto->fechaFin = $request->input('fecha_fin');
        $proyecto->idClienteProy = $request->input('idCliente');

        $proyecto->update();

        return Redirect::route('proyectos.lista')->with('success', 'Proyecto actualizado exitosamente');
    }


    public function toggleStatus($id)
    {
        $proyecto = Proyecto::findOrFail($id);

        // Cambiar el estado del proyecto
        $proyecto->status = $proyecto->status == 0 ? 1 : 0;
        $proyecto->save();

        // Redirigir o retornar una respuesta adecuada
        return redirect()->back()->with('success', 'El estado del proyecto se ha cambiado correctamente.');
    }

    public function eliminarProyecto($id)
    {
        Proyecto::where('idProy', $id)->delete();

        return redirect()->route('proyectos.lista')->with('success', 'Proyecto eliminado correctamente.');
    }
}
