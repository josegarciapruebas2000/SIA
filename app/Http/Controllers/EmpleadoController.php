<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\DocsEmpleado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        // Después de guardar el empleado, crea una fila en la tabla docsEmpleado
        $docsEmpleado = new DocsEmpleado();
        $docsEmpleado->id_Emp = $empleado->id_Emp; // Asigna el ID del empleado
        $docsEmpleado->save();

        // Devuelve una respuesta de redirección con un mensaje de éxito
        return redirect()->route('empleados.lista')->with('success', 'Se agregó el empleado correctamente.');
    }




    public function cargarEmpleado($id)
    {
        $empleado = Empleado::find($id);

        // Verificar si se encontró el empleado
        if ($empleado) {
            // Si se encontró, puedes devolver los datos del empleado
            return view('dashboard.empleados.editar-empleado', compact('empleado'));
        } else {
            // Si no se encontró, puedes redirigir con un mensaje de error o manejarlo de otra manera
            return redirect()->back()->with('error', 'Empleado no encontrado.');
        }
    }


    public function actualizarEmpleado(Request $request, $id)
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
            'puesto' => 'nullable|string|max:255',
            'fecha' => 'required|date',
        ]);

        // Busca al empleado por su ID
        $empleado = Empleado::findOrFail($id);

        // Actualiza los campos del empleado solo si han cambiado
        $empleado->nombre_Emp = $request->input('nombre', $empleado->nombre_Emp);
        $empleado->app_paterno_Emp = $request->input('apellido_paterno', $empleado->app_paterno_Emp);
        $empleado->app_materno_Emp = $request->input('apellido_materno', $empleado->app_materno_Emp);
        $empleado->sexo_Emp = $request->input('sexo', $empleado->sexo_Emp);
        $empleado->NSS_Emp = $request->input('nss', $empleado->NSS_Emp);
        $empleado->curp_Emp = $request->input('curp', $empleado->curp_Emp);
        $empleado->RFC_Emp = $request->input('rfc', $empleado->RFC_Emp);
        $empleado->telefono_Emp = $request->input('telefono', $empleado->telefono_Emp);
        $empleado->direccion_Emp = $request->input('direccion', $empleado->direccion_Emp);
        $empleado->correo_Emp = $request->input('correo', $empleado->correo_Emp);
        $empleado->fechaAlta_Emp = $request->input('fecha', $empleado->fechaAlta_Emp);

        if ($request->input('departamento') != $empleado->departamento || $request->input('puesto') != $empleado->puesto_Emp) {
            // Actualiza los campos de departamento y puesto solo si han cambiado
            $empleado->departamento = $request->input('departamento');
            $empleado->puesto_Emp = $request->input('puesto');
        }

        // Guarda los cambios
        $empleado->save();

        // Redirige a la página de lista de empleados con un mensaje de éxito
        return redirect()->route('empleados.lista')->with('success', 'Los datos del empleado se han actualizado correctamente.');
    }


    public function documentoEmpleado($id)
    {
        $empleado = DocsEmpleado::find($id);

        // Verificar si se encontró el empleado
        if ($empleado) {
            // Obtener los documentos asociados al empleado
            $docsEmpleado = DocsEmpleado::where('id_Emp', $id)->first();

            // Si no hay documentos asociados, crear una instancia vacía
            if (!$docsEmpleado) {
                $docsEmpleado = new DocsEmpleado();
            }

            // Pasar los datos del empleado y los documentos a la vista
            return view('dashboard.empleados.documentos', compact('empleado', 'docsEmpleado'));
        } else {
            // Si no se encontró, puedes redirigir con un mensaje de error o manejarlo de otra manera
            return redirect()->back()->with('error', 'Empleado no encontrado.');
        }
    }






    public function addDocumentoEmpleado(Request $request, $id)
    {
        // Obtener el registro existente de DocsEmpleado asociado al empleado
        $docsEmpleado = DocsEmpleado::where('id_Emp', $id)->first();

        // Si no hay un registro existente, crear uno nuevo
        if (!$docsEmpleado) {
            $docsEmpleado = new DocsEmpleado();
            $docsEmpleado->id_Emp = $id;
        }

        // Actualizar los archivos en el registro existente
        $docsEmpleado->solicitud_empleo = $request->file('solicitud_empleo') ? $request->file('solicitud_empleo')->store('docs') : $docsEmpleado->solicitud_empleo;
        $docsEmpleado->constancia_fiscal = $request->file('constancia_fiscal') ? $request->file('constancia_fiscal')->store('docs') : $docsEmpleado->constancia_fiscal;
        $docsEmpleado->titulo_universidad = $request->file('titulo_universidad') ? $request->file('titulo_universidad')->store('docs') : $docsEmpleado->titulo_universidad;
        $docsEmpleado->ine = $request->file('ine') ? $request->file('ine')->store('docs') : $docsEmpleado->ine;
        $docsEmpleado->comprobante_domicilio = $request->file('comprobante_domicilio') ? $request->file('comprobante_domicilio')->store('docs') : $docsEmpleado->comprobante_domicilio;
        $docsEmpleado->cedula = $request->file('cedula') ? $request->file('cedula')->store('docs') : $docsEmpleado->cedula;
        $docsEmpleado->curp = $request->file('curp') ? $request->file('curp')->store('docs') : $docsEmpleado->curp;
        $docsEmpleado->nss = $request->file('nss') ? $request->file('nss')->store('docs') : $docsEmpleado->nss;
        $docsEmpleado->comprobatorio_experiencia = $request->file('comprobatorio_experiencia') ? $request->file('comprobatorio_experiencia')->store('docs') : $docsEmpleado->comprobatorio_experiencia;

        // Guardar los cambios en la base de datos
        $docsEmpleado->save();

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Documentos actualizados correctamente.');
    }


    public function descargarDocumento($id, $tipo)
    {
        // Obtener el nombre de la columna en función del tipo de documento
        $columnaDocumento = $this->getColumnaDocumento($tipo);

        // Obtener el documento del empleado desde la base de datos
        $documento = DocsEmpleado::where('id_Emp', $id)->value($columnaDocumento);

        // Verificar si se encontró el documento y si existe
        if ($documento) {
            // Devolver el archivo para descargar
            return response()->download(storage_path('app/' . $documento));
        } else {
            // Si no se encuentra el documento, redirigir o mostrar un mensaje de error
            return redirect()->back()->with('error', 'El documento solicitado no está disponible.');
        }
    }

    // Método para obtener el nombre de la columna del documento en función del tipo
    private function getColumnaDocumento($tipo)
    {
        // Aquí puedes definir la lógica para mapear el tipo de documento a la columna correspondiente
        // Por ejemplo, si el tipo es 'solicitud_empleo', devolverías el nombre de la columna correspondiente a esa solicitud
        // Debes implementar este método según la estructura de tu base de datos
        // Por ejemplo:
        switch ($tipo) {
            case 'solicitud_empleo':
                return 'solicitud_empleo';
            case 'constancia_fiscal':
                return 'constancia_fiscal';
            case 'titulo_universidad':
                return 'titulo_universidad';
            case 'ine':
                return 'ine';
            case 'comprobante_domicilio':
                return 'comprobante_domicilio';
            case 'cedula':
                return 'cedula';
            case 'curp':
                return 'curp';
            case 'nss':
                return 'nss';
            case 'comprobatorio_experiencia':
                return 'comprobatorio_experiencia';
            default:
                return null;
        }
    }
}
