<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreditosController extends Controller
{
    public function index()
    {
        // Obtener los créditos registrados
        $creditos = DB::table('creditos')->get();
    
        // Pasar los datos a la vista
        return view('finanzas.creditos.index', compact('creditos'));
    }

    public function create()
    {
        $bancos = ['Banco de Chile', 'Banco Estado', 'Santander', 'BCI', 'Scotiabank', 'Banco Falabella', 'Banco Ripley'];
        return view('finanzas.creditos.create', compact('bancos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banco' => 'required|string',
            'monto' => 'required|numeric|min:0',
            'cuotas' => 'required|integer|min:1',
            'tasa_interes' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
        ]);

        // Calcular el monto total con interés
        $montoTotal = $validatedData['monto'] * (1 + ($validatedData['tasa_interes'] / 100));
        $montoCuota = $montoTotal / $validatedData['cuotas'];

        // Insertar el crédito
        $creditoId = DB::table('creditos')->insertGetId([
            'banco' => $validatedData['banco'],
            'monto' => $validatedData['monto'],
            'cuotas' => $validatedData['cuotas'],
            'tasa_interes' => $validatedData['tasa_interes'],
            'monto_total' => $montoTotal,
            'fecha_inicio' => $validatedData['fecha_inicio'],
        ]);

        // Insertar las cuotas
        $fechaPago = Carbon::createFromFormat('Y-m-d', $validatedData['fecha_inicio']);
        for ($i = 0; $i < $validatedData['cuotas']; $i++) {
            DB::table('creditos_cuotas')->insert([
                'credito_id' => $creditoId,
                'monto_cuota' => $montoCuota,
                'interes' => $montoTotal * ($validatedData['tasa_interes'] / 100) / $validatedData['cuotas'],
                'capital' => $montoCuota - ($montoTotal * ($validatedData['tasa_interes'] / 100) / $validatedData['cuotas']),
                'fecha_pago' => $fechaPago->format('Y-m-d'),
                'pagado' => 0,
            ]);
            $fechaPago->addMonth(); // Avanzar al siguiente mes
        }

        return redirect()->route('finanzas.creditos.index')->with('success', 'Crédito registrado exitosamente');
    }

    public function show($id)
    {
        // Obtener el crédito específico
        $credito = DB::table('creditos')->where('id', $id)->first();

        // Verificar si el crédito existe
        if (!$credito) {
            return redirect()->route('finanzas.creditos.index')->with('error', 'Crédito no encontrado.');
        }

        // Obtener las cuotas relacionadas
        $cuotas = DB::table('creditos_cuotas')->where('credito_id', $id)->get();

        // Retornar la vista con los datos del crédito
        return view('finanzas.creditos.show', compact('credito', 'cuotas'));
    }

    public function edit($id)
    {
        // Buscar el crédito específico
        $credito = DB::table('creditos')->where('id', $id)->first();

        // Verificar si el crédito existe
        if (!$credito) {
            return redirect()->route('finanzas.creditos.index')->with('error', 'Crédito no encontrado.');
        }

        // Lista de bancos para el formulario
        $bancos = ['Banco de Chile', 'Banco Estado', 'Santander', 'BCI', 'Scotiabank', 'Banco Falabella', 'Banco Ripley'];

        // Retornar la vista con los datos del crédito
        return view('finanzas.creditos.edit', compact('credito', 'bancos'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'banco' => 'required|string',
            'monto' => 'required|numeric|min:0',
            'cuotas' => 'required|integer|min:1',
            'tasa_interes' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
        ]);

        // Actualizar el crédito
        DB::table('creditos')->where('id', $id)->update([
            'banco' => $validatedData['banco'],
            'monto' => $validatedData['monto'],
            'cuotas' => $validatedData['cuotas'],
            'tasa_interes' => $validatedData['tasa_interes'],
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'updated_at' => now(),
        ]);

        return redirect()->route('finanzas.creditos.index')->with('success', 'Crédito actualizado exitosamente.');
    }


}
