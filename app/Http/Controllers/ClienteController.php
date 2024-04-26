<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{
    public function listaClientes()
    {
        $clientes = Cliente::orderBy('idCliente', 'desc')->paginate(5);

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

    public function editarCliente(Request $request, $id) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255|not_in:Seleccionar',
        ]);

        $cliente = Cliente::find($id);

        $cliente->nombre = $request->input('nombre');
        $cliente->categoriaCliente = $request->input('categoria');

        $cliente->update();

        return Redirect::route('clientes.lista')->with('success', 'Cliente actualizado exitosamente');
    }
}
