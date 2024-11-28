<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonosController extends Controller
{
    public function index()
    {
        $bonos = DB::table('bonos')
            ->join('trabajadores', 'bonos.trabajador_id', '=', 'trabajadores.id')
            ->select('bonos.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.bonos.index', compact('bonos'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.bonos.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'monto' => 'required|numeric|min:0',
            'mes' => 'required|date_format:Y-m',
            'comentario' => 'nullable|string',
        ]);
    
        // Convertir el mes en un formato completo de fecha (primer día del mes)
        $validatedData['mes'] = $validatedData['mes'] . '-01';
    
        DB::table('bonos')->insert($validatedData);
    
        return redirect()->route('rrhh.bonos.index')->with('success', 'Bono registrado exitosamente');
    }
}
