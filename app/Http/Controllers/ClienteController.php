<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('configuracion.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('configuracion.clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rut' => 'required|unique:clientes,rut',
            'nombre' => 'required',
            'tipo' => 'required',
        ]);

        Cliente::create($validated);
        return redirect()->route('configuracion.clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    public function edit(Cliente $cliente)
    {
        return view('configuracion.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'rut' => 'required|unique:clientes,rut,' . $cliente->id,
            'nombre' => 'required',
            'tipo' => 'required',
        ]);

        $cliente->update($validated);
        return redirect()->route('configuracion.clientes.index')->with('success', 'Cliente actualizado');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
    
        return redirect()->route('configuracion.clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
