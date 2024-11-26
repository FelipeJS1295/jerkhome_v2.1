<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('configuracion.proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('configuracion.proveedores.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut' => 'required|unique:proveedores,rut',
            'nombre' => 'required',
            'email' => 'required|email',
            'contacto' => 'required',
        ]);
    
        Proveedor::create($validatedData);
    
        return redirect()->route('configuracion.proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        return view('configuracion.proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'rut' => 'required|unique:proveedores,rut,' . $proveedor->id,
            'nombre' => 'required',
            'email' => 'required|email',
            'contacto' => 'required',
        ]);

        $proveedor->update($validated);
        return redirect()->route('configuracion.proveedores.index')->with('success', 'Proveedor actualizado');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->route('configuracion.proveedores.index')->with('success', 'Proveedor eliminado');
    }
}
