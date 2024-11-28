<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanillaSueldosController extends Controller
{
    public function index()
    {
        $mesActual = Carbon::now()->format('Y-m'); // Formato '2024-11'
    
        $trabajadores = DB::table('trabajadores')->get();
    
        $planilla = $trabajadores->map(function ($trabajador) use ($mesActual) {
            // Sueldo base
            $sueldoBase = $trabajador->sueldo;
    
            // Cálculo del valor hora
            $valorHora = $sueldoBase / (30 * 8);
    
            // Horas Extras
            $horasExtras = DB::table('horas_extras')
                ->where('trabajador_id', $trabajador->id)
                ->where('fecha', 'like', $mesActual . '%')
                ->get();
    
            $totalHorasExtras = $horasExtras->sum(function ($horaExtra) use ($valorHora) {
                $horas = (strtotime($horaExtra->hora_hasta) - strtotime($horaExtra->hora_desde)) / 3600;
                return $horas * $valorHora * 1.5; // Pago 1.5 veces por hora extra
            });
    
            // Faltas
            $faltas = DB::table('faltas')
                ->where('trabajador_id', $trabajador->id)
                ->where('dia', 'like', $mesActual . '%')
                ->get();
    
            $totalFaltas = $faltas->sum(function ($falta) use ($valorHora, $sueldoBase) {
                if ($falta->tipo === 'día') {
                    return $sueldoBase / 30; // Descuento por día
                } elseif ($falta->tipo === 'horas') {
                    $horas = (strtotime($falta->hora_hasta) - strtotime($falta->hora_desde)) / 3600;
                    return $horas * $valorHora; // Descuento por hora
                }
                return 0;
            });
    
            // Vacaciones
            $vacaciones = DB::table('vacaciones')
                ->where('trabajador_id', $trabajador->id)
                ->where('fecha_desde', 'like', $mesActual . '%')
                ->get();
    
            $totalVacaciones = $vacaciones->sum(function ($vacacion) use ($sueldoBase) {
                return $vacacion->estado === 'no autorizado' ? $sueldoBase / 30 : 0;
            });
    
            // Bonos
            $bonos = DB::table('bonos')
                ->where('trabajador_id', $trabajador->id)
                ->where('mes', 'like', $mesActual . '%')
                ->sum('monto');
    
            // Quincenas (Descuento)
            $quincenas = DB::table('quincenas')
                ->where('trabajador_id', $trabajador->id)
                ->where('mes', 'like', $mesActual . '%')
                ->sum('monto');
    
            // Préstamos (Descuento)
            $prestamos = DB::table('prestamos_cuotas')
                ->where('trabajador_id', $trabajador->id)
                ->where('mes', 'like', $mesActual . '%')
                ->where('pagado', 0) // Solo cuotas no pagadas
                ->sum('monto_cuota');
    
            // Cálculo total
            $total = $sueldoBase + $totalHorasExtras + $bonos - $totalFaltas - $totalVacaciones - $quincenas - $prestamos;
    
            return [
                'trabajador' => $trabajador->nombres . ' ' . $trabajador->apellidos,
                'rut' => $trabajador->rut,
                'sueldo_base' => $sueldoBase,
                'horas_extras' => $totalHorasExtras,
                'faltas' => $totalFaltas,
                'vacaciones' => $totalVacaciones,
                'bonos' => $bonos,
                'quincenas' => $quincenas,
                'prestamos' => $prestamos,
                'total' => $total,
            ];
        });
    
        return view('rrhh.planilla_sueldos.index', compact('planilla'));
    }
    
}
