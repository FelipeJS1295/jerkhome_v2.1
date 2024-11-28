<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;

class RecursosHumanosController extends Controller
{
    // Vista principal de RRHH
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('rrhh.index', compact('trabajadores'));
    }

    // Trabajadores
    public function create()
    {
        return view('rrhh.trabajadores.create');
    }

    public function edit($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('rrhh.trabajadores.edit', compact('trabajador'));
    }

    // Sueldos
    public function salaries()
    {
        return view('rrhh.sueldos.index');
    }

    // Horas Extras
    public function extraHours()
    {
        return view('rrhh.horasextras.index');
    }

    // Faltas
    public function absences()
    {
        return view('rrhh.faltas.index');
    }

    // Vacaciones
    public function vacations()
    {
        return view('rrhh.vacaciones.index');
    }

    // Bonos
    public function bonuses()
    {
        return view('rrhh.bonos.index');
    }
}
