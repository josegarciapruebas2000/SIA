<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{
    public function listaClientes(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $search = $request->input('search');

        // Consulta inicial para obtener todos los clientes
        $query = Cliente::query();

        // Aplicar filtros si se proporciona un término de búsqueda
        if ($search) {
            $query->where('idCliente', 'LIKE', '%' . $search . '%')
                ->orWhere('nombre', 'LIKE', '%' . $search . '%')
                ->orWhere('CategoriaCliente', 'LIKE', '%' . $search . '%');
        }

        // Obtener los clientes filtrados y paginados
        $clientes = $query->orderBy('idCliente', 'desc')->paginate(5);

        // Pasar los clientes a la vista
        return view('dashboard.clientes.clientes', compact('clientes'));
    }


    public function agregarCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255|not_in:Seleccionar',
        ]);

        $cliente = new Cliente;

        $cliente->nombre = $request->input('nombre');
        $cliente->categoriaCliente = $request->input('categoria');
        $cliente->status = 1;

        $cliente->save();

        return Redirect::route('clientes.lista')->with('success', 'Cliente agregado exitosamente');
    }

    public function toggleStatus($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verificar el método de la solicitud
        if (request()->isMethod('get')) {
            // Cambiar el estado del cliente
            $cliente->status = $cliente->status == 0 ? 1 : 0;
            $cliente->save();

            // Redirigir o retornar una respuesta adecuada
            return redirect()->back()->with('success', 'El estado del cliente se ha cambiado correctamente.');
        } elseif (request()->isMethod('post')) {
            // Lógica adicional para manejar solicitudes POST, si es necesario
        }
    }

    public function eliminarCliente(Request $request, $id)
    {
        // Aquí iría la lógica para eliminar el cliente si no tiene proyectos asociados
        $cliente = Cliente::findOrFail($id);
        $proyectosAsociados = Proyecto::where('idClienteProy', $id)->exists();

        if (!$proyectosAsociados) {
            $cliente->delete();
            return redirect()->route('clientes.lista')->with('success', 'Cliente eliminado correctamente.');
        } else {
            return redirect()->route('clientes.lista')->with('error', 'No se puede eliminar el cliente porque tiene proyectos asociados.');
        }
    }


    public function editarCliente(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255|not_in:Seleccionar',
        ]);

        $cliente = Cliente::findOrFail($id);

        $cliente->nombre = $request->input('nombre');
        $cliente->categoriaCliente = $request->input('categoria');

        $cliente->update();

        return Redirect::route('clientes.lista')->with('success', 'Cliente actualizado exitosamente');
    }
}
