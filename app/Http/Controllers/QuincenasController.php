<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuincenasController extends Controller
{
    public function index()
    {
        $quincenas = DB::table('quincenas')
            ->join('trabajadores', 'quincenas.trabajador_id', '=', 'trabajadores.id')
            ->select('quincenas.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.quincenas.index', compact('quincenas'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.quincenas.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'monto' => 'required|numeric|min:0',
            'mes' => 'required|date_format:Y-m',
        ]);

        // Convertir el mes al formato completo
        $validatedData['mes'] = $validatedData['mes'] . '-01';

        DB::table('quincenas')->insert($validatedData);

        return redirect()->route('rrhh.quincenas.index')->with('success', 'Quincena registrada exitosamente');
    }
}
