<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::all();
        return view('configuracion.insumos.index', compact('insumos'));
    }

    public function create()
    {
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores
        return view('configuracion.insumos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku_padre' => 'required',
            'sku_hijo' => 'nullable',
            'nombre' => 'required',
            'unidad_medida' => 'required',
            'proveedor_id' => 'required|exists:proveedores,id',
            'precio_costo' => 'required|numeric',
            'precio_venta' => 'required|numeric'
        ]);

        Insumo::create($validated);
        return redirect()->route('insumos.index')->with('success', 'Insumo creado exitosamente');
    }

    public function edit(Insumo $insumo)
    {
        $proveedores = Proveedor::all();
        return view('configuracion.insumos.edit', compact('insumo', 'proveedores'));
    }

    public function update(Request $request, Insumo $insumo)
    {
        $validated = $request->validate([
            'sku_padre' => 'required',
            'sku_hijo' => 'nullable',
            'nombre' => 'required',
            'unidad_medida' => 'required',
            'proveedor_id' => 'required|exists:proveedores,id',
            'precio_costo' => 'required|numeric',
            'precio_venta' => 'required|numeric'
        ]);

        $insumo->update($validated);
        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado');
    }
}
