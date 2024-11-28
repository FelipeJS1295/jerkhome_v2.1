<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IVAController extends Controller
{
    public function index()
    {
        $ivas = DB::table('iva')->get();
        return view('finanzas.iva.index', compact('ivas'));
    }

    public function create()
    {
        return view('finanzas.iva.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'estado' => 'required|in:Pagado,Pendiente',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('iva')->insert([
            'monto' => $validatedData['monto'],
            'fecha' => $validatedData['fecha'],
            'estado' => $validatedData['estado'],
            'descripcion' => $validatedData['descripcion'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.iva.index')->with('success', 'Registro de I.V.A. creado exitosamente.');
    }

    public function show($id)
    {
        $iva = DB::table('iva')->where('id', $id)->first();

        if (!$iva) {
            return redirect()->route('finanzas.iva.index')->with('error', 'Registro de I.V.A. no encontrado.');
        }

        return view('finanzas.iva.show', compact('iva'));
    }

    public function edit($id)
    {
        $iva = DB::table('iva')->where('id', $id)->first();

        if (!$iva) {
            return redirect()->route('finanzas.iva.index')->with('error', 'Registro de I.V.A. no encontrado.');
        }

        return view('finanzas.iva.edit', compact('iva'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'estado' => 'required|in:Pagado,Pendiente',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('iva')->where('id', $id)->update([
            'monto' => $validatedData['monto'],
            'fecha' => $validatedData['fecha'],
            'estado' => $validatedData['estado'],
            'descripcion' => $validatedData['descripcion'],
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.iva.index')->with('success', 'Registro de I.V.A. actualizado exitosamente.');
    }

    public function destroy($id)
    {
        DB::table('iva')->where('id', $id)->delete();

        return redirect()->route('finanzas.iva.index')->with('success', 'Registro de I.V.A. eliminado exitosamente.');
    }
}
