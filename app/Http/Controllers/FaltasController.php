<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaltasController extends Controller
{
    public function index()
    {
        $faltas = DB::table('faltas')
            ->join('trabajadores', 'faltas.trabajador_id', '=', 'trabajadores.id')
            ->select('faltas.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.faltas.index', compact('faltas'));
    }

    public function createDia()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.faltas.create_dia', compact('trabajadores'));
    }

    public function createHoras()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.faltas.create_horas', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'tipo' => 'required|in:día,horas',
            'dia' => 'required|date',
            'hora_desde' => 'nullable|date_format:H:i',
            'hora_hasta' => 'nullable|date_format:H:i|after:hora_desde',
            'justificado' => 'nullable|boolean',
            'comentario' => 'nullable|string',
        ]);

        DB::table('faltas')->insert($validatedData);

        return redirect()->route('rrhh.faltas.index')->with('success', 'Falta registrada exitosamente');
    }
}
