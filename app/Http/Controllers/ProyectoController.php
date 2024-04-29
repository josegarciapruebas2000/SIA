<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Cliente;
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

        // Pasar los proyectos y clientes a la vista
        return view('dashboard.proyectos.proyectos', compact('proyectos', 'clientes'));
    }


    public function agregarProyecto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'moneda' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'idCliente' => 'required|numeric', // Aquí estás validando el campo como 'idCliente'
        ]);

        // Buscar el ID del cliente basado en el nombre proporcionado
        $idCliente = Cliente::where('nombre', $request->input('nombreCliente'))->value('idCliente');

        // Crear el proyecto y guardar el ID del cliente
        $proyecto = new Proyecto;
        $proyecto->nombreProy = $request->input('nombre');
        $proyecto->montoProy = $request->input('monto');
        $proyecto->monedaProy = $request->input('moneda');
        $proyecto->estadoProy = $request->input('estado');
        $proyecto->idClienteProy = $request->input('idCliente'); // Guardar el ID del cliente
        $proyecto->status = 1;

        $proyecto->save();

        return redirect()->route('proyectos.lista')->with('success', 'Proyecto agregado exitosamente');
    }

    public function editarProyecto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'moneda' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'idCliente' => 'required|numeric',
        ]);

        $proyecto = Proyecto::findOrFail($id);

        $proyecto->nombreProy = $request->input('nombre');
        $proyecto->montoProy = $request->input('monto');
        $proyecto->monedaProy = $request->input('moneda');
        $proyecto->estadoProy = $request->input('estado');
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
