<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = DB::table('trabajadores')->get();
        return view('rrhh.index', compact('trabajadores'));
    }

    public function create()
    {
        $users = DB::table('users')->select('id', 'nombre_usuario', 'email')->get();
        $afp = ['AFP Habitat', 'AFP Cuprum', 'AFP Capital', 'AFP Provida', 'AFP Modelo'];
        $salud = ['Fonasa', 'Isapre Colmena', 'Isapre Cruz Blanca', 'Isapre Banmédica', 'Isapre Vida Tres'];
        return view('rrhh.create', compact('users', 'afp', 'salud'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rut' => 'required|string|max:15|unique:trabajadores,rut',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'afp' => 'required|string',
            'salud' => 'required|string',
            'sueldo' => 'required|numeric',
            'fecha_ingreso' => 'required|date',
            'talla_polera' => 'required|string|max:10',
            'talla_zapatos' => 'required|string|max:10',
            'talla_pantalon' => 'required|string|max:10',
        ]);

        DB::table('trabajadores')->insert($validatedData);

        return redirect()->route('rrhh.index')->with('success', 'Trabajador agregado exitosamente');
    }

    public function edit($id)
    {
        $trabajador = DB::table('trabajadores')->find($id);
        $afp = ['AFP Habitat', 'AFP Cuprum', 'AFP Capital', 'AFP Provida', 'AFP Modelo'];
        $salud = ['Fonasa', 'Isapre Colmena', 'Isapre Cruz Blanca', 'Isapre Banmédica', 'Isapre Vida Tres'];

        return view('rrhh.edit', compact('trabajador', 'afp', 'salud'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rut' => 'required|string|max:15|unique:trabajadores,rut,' . $id,
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'afp' => 'required|string',
            'salud' => 'required|string',
            'sueldo' => 'required|numeric',
            'fecha_ingreso' => 'required|date',
            'talla_polera' => 'required|string|max:10',
            'talla_zapatos' => 'required|string|max:10',
            'talla_pantalon' => 'required|string|max:10',
        ]);

        DB::table('trabajadores')->where('id', $id)->update($validatedData);

        return redirect()->route('rrhh.index')->with('success', 'Trabajador actualizado exitosamente');
    }

    public function destroy($id)
    {
        DB::table('trabajadores')->where('id', $id)->delete();
        return redirect()->route('rrhh.index')->with('success', 'Trabajador eliminado exitosamente');
    }
}
