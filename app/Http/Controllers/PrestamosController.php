<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrestamosController extends Controller
{
    public function index()
    {
        $prestamos = DB::table('prestamos')
            ->join('trabajadores', 'prestamos.trabajador_id', '=', 'trabajadores.id')
            ->select('prestamos.*', 'trabajadores.nombres', 'trabajadores.apellidos', 'trabajadores.rut')
            ->get();

        return view('rrhh.prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();
        return view('rrhh.prestamos.create', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|integer|exists:trabajadores,id',
            'monto' => 'required|numeric|min:0',
            'cuotas' => 'required|integer|min:1',
            'mes_inicio' => 'required|date_format:Y-m',
        ]);

        // Insertar el préstamo
        $prestamoId = DB::table('prestamos')->insertGetId([
            'trabajador_id' => $request->trabajador_id,
            'monto' => $request->monto,
            'cuotas' => $request->cuotas,
            'mes_inicio' => $request->mes_inicio . '-01',
        ]);

        // Calcular las cuotas
        $montoCuota = $request->monto / $request->cuotas;
        $mesInicio = Carbon::createFromFormat('Y-m', $request->mes_inicio)->startOfMonth();

        for ($i = 0; $i < $request->cuotas; $i++) {
            DB::table('prestamos_cuotas')->insert([
                'prestamo_id' => $prestamoId,
                'trabajador_id' => $request->trabajador_id,
                'monto_cuota' => $montoCuota,
                'mes' => $mesInicio->format('Y-m-d'),
                'pagado' => 0,
            ]);

            $mesInicio->addMonth(); // Avanzar al siguiente mes
        }

        return redirect()->route('rrhh.prestamos.index')->with('success', 'Préstamo registrado exitosamente');
    }

    public function registrarPago(Request $request, $id)
    {
        // Encontrar la cuota pendiente más próxima
        $cuota = DB::table('prestamos_cuotas')
            ->where('prestamo_id', $id)
            ->where('pagado', 0)
            ->orderBy('mes', 'asc')
            ->first();

        if (!$cuota) {
            return redirect()->route('rrhh.prestamos.index')->with('error', 'No hay cuotas pendientes para este préstamo.');
        }

        // Registrar el pago
        DB::table('prestamos_cuotas')->where('id', $cuota->id)->update(['pagado' => 1]);

        return redirect()->route('rrhh.prestamos.index')->with('success', 'Pago registrado exitosamente.');
    }

    public function aplazarCuota(Request $request, $id)
    {
        // Encontrar la cuota pendiente más próxima
        $cuota = DB::table('prestamos_cuotas')
            ->where('prestamo_id', $id)
            ->where('pagado', 0)
            ->orderBy('mes', 'asc')
            ->first();

        if (!$cuota) {
            return redirect()->route('rrhh.prestamos.index')->with('error', 'No hay cuotas pendientes para este préstamo.');
        }

        // Aplazar la cuota al siguiente mes
        $nuevoMes = Carbon::createFromFormat('Y-m-d', $cuota->mes)->addMonth();
        DB::table('prestamos_cuotas')->where('id', $cuota->id)->update(['mes' => $nuevoMes->format('Y-m-d')]);

        return redirect()->route('rrhh.prestamos.index')->with('success', 'Cuota aplazada exitosamente.');
    }

    public function edit($id)
    {
        $prestamo = DB::table('prestamos')->find($id);
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres', 'apellidos')->get();

        return view('rrhh.prestamos.edit', compact('prestamo', 'trabajadores'));
    }
}
