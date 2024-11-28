<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnticiposController extends Controller
{
    public function index()
    {
        $anticipos = DB::table('anticipos')
            ->join('trabajadores', 'anticipos.trabajador_id', '=', 'trabajadores.id')
            ->select('anticipos.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.anticipos.index', compact('anticipos'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.anticipos.create', compact('trabajadores'));
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

        DB::table('anticipos')->insert($validatedData);

        return redirect()->route('rrhh.anticipos.index')->with('success', 'Anticipo registrado exitosamente');
    }
}
