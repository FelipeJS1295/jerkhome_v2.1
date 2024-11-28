<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacacionesController extends Controller
{
    public function index()
    {
        $vacaciones = DB::table('vacaciones')
            ->join('trabajadores', 'vacaciones.trabajador_id', '=', 'trabajadores.id')
            ->select('vacaciones.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.vacaciones.index', compact('vacaciones'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.vacaciones.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
            'estado' => 'required|in:autorizado,no autorizado',
        ]);

        DB::table('vacaciones')->insert($validatedData);

        return redirect()->route('rrhh.vacaciones.index')->with('success', 'Vacaciones registradas exitosamente');
    }
}
