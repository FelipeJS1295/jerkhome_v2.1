<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastosExtrasController extends Controller
{
    /**
     * Mostrar la lista de gastos extras.
     */
    public function index()
    {
        $gastos = DB::table('gastos_extras')->get();
        return view('finanzas.gastos.index', compact('gastos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo gasto.
     */
    public function create()
    {
        return view('finanzas.gastos.create');
    }

    /**
     * Guardar un nuevo gasto en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipo_gasto' => 'required|in:Luz,Agua,Arriendo,Otros',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|in:Pagado,Pendiente',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('gastos_extras')->insert([
            'tipo_gasto' => $validatedData['tipo_gasto'],
            'fecha' => $validatedData['fecha'],
            'monto' => $validatedData['monto'],
            'estado' => $validatedData['estado'],
            'descripcion' => $validatedData['descripcion'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.gastos.index')->with('success', 'Gasto registrado exitosamente.');
    }

    /**
     * Mostrar el detalle de un gasto específico.
     */
    public function show($id)
    {
        $gasto = DB::table('gastos_extras')->where('id', $id)->first();

        if (!$gasto) {
            return redirect()->route('finanzas.gastos.index')->with('error', 'Gasto no encontrado.');
        }

        return view('finanzas.gastos.show', compact('gasto'));
    }

    /**
     * Mostrar el formulario para editar un gasto existente.
     */
    public function edit($id)
    {
        $gasto = DB::table('gastos_extras')->where('id', $id)->first();

        if (!$gasto) {
            return redirect()->route('finanzas.gastos.index')->with('error', 'Gasto no encontrado.');
        }

        return view('finanzas.gastos.edit', compact('gasto'));
    }

    /**
     * Actualizar un gasto existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipo_gasto' => 'required|in:Luz,Agua,Arriendo,Otros',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|in:Pagado,Pendiente',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('gastos_extras')->where('id', $id)->update([
            'tipo_gasto' => $validatedData['tipo_gasto'],
            'fecha' => $validatedData['fecha'],
            'monto' => $validatedData['monto'],
            'estado' => $validatedData['estado'],
            'descripcion' => $validatedData['descripcion'],
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.gastos.index')->with('success', 'Gasto actualizado exitosamente.');
    }

    /**
     * Eliminar un gasto de la base de datos.
     */
    public function destroy($id)
    {
        DB::table('gastos_extras')->where('id', $id)->delete();

        return redirect()->route('finanzas.gastos.index')->with('success', 'Gasto eliminado exitosamente.');
    }
}
