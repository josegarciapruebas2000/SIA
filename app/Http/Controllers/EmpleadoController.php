<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function listaEmpleados(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $search = $request->input('search');
        // Obtener el filtro de departamento seleccionado
        $filtroDepartamento = $request->input('filtro_departamento');

        // Consulta inicial para obtener todos los empleados
        $query = Empleado::query();

        // Aplicar filtros si se proporciona un término de búsqueda
        if ($search) {
            $query->where('id_Emp', 'LIKE', '%' . $search . '%')
                ->orWhere('nombre_Emp', 'LIKE', '%' . $search . '%')
                ->orWhere('puesto_Emp', 'LIKE', '%' . $search . '%');
        }

        // Aplicar filtro por departamento si se selecciona uno
        if ($filtroDepartamento && $filtroDepartamento != 'Todos') {
            $query->where('departamento', $filtroDepartamento);
        }

        // Obtener los empleados filtrados y paginados
        $empleados = $query->orderBy('id_Emp', 'desc')->paginate(5);

        // Pasar los empleados a la vista
        return view('dashboard.empleados.empleados', compact('empleados'));
    }


    public function toggleStatus($id)
    {
        $empleados = Empleado::findOrFail($id);

        // Cambiar el estado del proyecto
        $empleados->status = $empleados->status == 0 ? 1 : 0;
        $empleados->save();

        // Redirigir o retornar una respuesta adecuada
        return redirect()->back()->with('success', 'El estado del proyecto se ha cambiado correctamente.');
    }
}
