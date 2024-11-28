<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoletasExtrasController extends Controller
{
    public function create()
    {
        // Obtener la lista de trabajadores para el formulario
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('finanzas.boletas.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'numero_boleta' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
        ]);

        // Insertar la boleta en la base de datos
        DB::table('boletas_extras')->insert([
            'trabajador_id' => $validatedData['trabajador_id'],
            'numero_boleta' => $validatedData['numero_boleta'],
            'descripcion' => $validatedData['descripcion'],
            'monto' => $validatedData['monto'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.boletas.index')->with('success', 'Boleta registrada exitosamente.');
    }

    public function index()
    {
        // Obtener las boletas extras con información del trabajador
        $boletas = DB::table('boletas_extras')
            ->join('trabajadores', 'boletas_extras.trabajador_id', '=', 'trabajadores.id')
            ->select('boletas_extras.*', 'trabajadores.nombres', 'trabajadores.apellidos')
            ->get();

        return view('finanzas.boletas.index', compact('boletas'));
    }

    public function show($id)
    {
        $boleta = DB::table('boletas_extras')
            ->join('trabajadores', 'boletas_extras.trabajador_id', '=', 'trabajadores.id')
            ->select('boletas_extras.*', 'trabajadores.nombres', 'trabajadores.apellidos')
            ->where('boletas_extras.id', $id)
            ->first();

        if (!$boleta) {
            return redirect()->route('finanzas.boletas.index')->with('error', 'Boleta no encontrada.');
        }

        return view('finanzas.boletas.show', compact('boleta'));
    }

    public function edit($id)
    {
        $boleta = DB::table('boletas_extras')->where('id', $id)->first();
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();

        if (!$boleta) {
            return redirect()->route('finanzas.boletas.index')->with('error', 'Boleta no encontrada.');
        }

        return view('finanzas.boletas.edit', compact('boleta', 'trabajadores'));
    }

    public function destroy($id)
    {
        DB::table('boletas_extras')->where('id', $id)->delete();

        return redirect()->route('finanzas.boletas.index')->with('success', 'Boleta eliminada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'numero_boleta' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
        ]);

        // Actualizar la boleta
        DB::table('boletas_extras')->where('id', $id)->update([
            'trabajador_id' => $validatedData['trabajador_id'],
            'numero_boleta' => $validatedData['numero_boleta'],
            'descripcion' => $validatedData['descripcion'],
            'monto' => $validatedData['monto'],
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.boletas.index')->with('success', 'Boleta actualizada exitosamente.');
    }


}
