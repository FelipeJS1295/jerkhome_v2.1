<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorasExtrasController extends Controller
{
    public function index()
    {
        $horasExtras = DB::table('horas_extras')
            ->join('trabajadores', 'horas_extras.trabajador_id', '=', 'trabajadores.id')
            ->select('horas_extras.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.horasextras.index', compact('horasExtras'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.horasextras.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'fecha' => 'required|date',
            'hora_desde' => 'required|date_format:H:i',
            'hora_hasta' => 'required|date_format:H:i|after:hora_desde',
        ]);

        DB::table('horas_extras')->insert([
            'trabajador_id' => $request->trabajador_id,
            'fecha' => $request->fecha,
            'hora_desde' => $request->hora_desde,
            'hora_hasta' => $request->hora_hasta,
        ]);

        return redirect()->route('rrhh.horas_extras.index')->with('success', 'Horas extras registradas exitosamente');
    }

    public function edit($id)
    {
        $horaExtra = DB::table('horas_extras')->find($id);
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.horasextras.edit', compact('horaExtra', 'trabajadores'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'fecha' => 'required|date',
            'hora_desde' => 'required|date_format:H:i',
            'hora_hasta' => 'required|date_format:H:i|after:hora_desde',
        ]);

        DB::table('horas_extras')->where('id', $id)->update([
            'trabajador_id' => $request->trabajador_id,
            'fecha' => $request->fecha,
            'hora_desde' => $request->hora_desde,
            'hora_hasta' => $request->hora_hasta,
        ]);

        return redirect()->route('rrhh.horas_extras.index')->with('success', 'Horas extras actualizadas exitosamente');
    }

    public function destroy($id)
    {
        DB::table('horas_extras')->where('id', $id)->delete();
        return redirect()->route('rrhh.horas_extras.index')->with('success', 'Horas extras eliminadas exitosamente');
    }
}
