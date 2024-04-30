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

    public function agregarEmpleado(Request $request)
    {
        // Valida los campos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'sexo' => 'required|in:H,M',
            'nss' => 'nullable|string|max:255',
            'curp' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:255',
            'departamento' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'puesto' => 'nullable|string|max:255',
            'fecha' => 'required|date',
        ]);

        // Crea un nuevo objeto Empleado con los datos del formulario
        $empleado = new Empleado();
        $empleado->RFC_Emp = $request->input('rfc');
        $empleado->nombre_Emp = $request->input('nombre');
        $empleado->app_paterno_Emp = $request->input('apellido_paterno');
        $empleado->app_materno_Emp = $request->input('apellido_materno');
        $empleado->NSS_Emp = $request->input('nss');
        $empleado->sexo_Emp = $request->input('sexo');
        $empleado->curp_Emp = $request->input('curp');
        $empleado->telefono_Emp = $request->input('telefono');
        $empleado->direccion_Emp = $request->input('direccion');
        $empleado->correo_Emp = $request->input('correo');
        $empleado->fechaAlta_Emp = $request->input('fecha');
        $empleado->puesto_Emp = $request->input('puesto');
        $empleado->departamento = $request->input('departamento');
        $empleado->status = 1; // Establece el valor predeterminado de status como 1

        // Guarda el empleado en la base de datos
        $empleado->save();

        // Devuelve una respuesta JSON indicando éxito
        return response()->json(['success' => true]);
    }
}
