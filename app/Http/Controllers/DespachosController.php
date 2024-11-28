<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DespachosController extends Controller
{
    public function index()
    {
        $despachos = DB::table('despachos')
            ->join('ventas_despachos', 'despachos.id', '=', 'ventas_despachos.despacho_id')
            ->join('ventas', 'ventas_despachos.venta_id', '=', 'ventas.id')
            ->select(
                'despachos.id',
                'despachos.tipo_despacho', // Cambiado de 'tipo' a 'tipo_despacho'
                'despachos.transporte',
                'despachos.conductor',
                'despachos.monto_despacho as monto', // Cambiado de 'monto' a 'monto_despacho'
                'despachos.estado',
                DB::raw('COUNT(ventas.id) as total_ordenes')
            )
            ->groupBy(
                'despachos.id',
                'despachos.tipo_despacho', // Cambiado de 'tipo' a 'tipo_despacho'
                'despachos.transporte',
                'despachos.conductor',
                'despachos.monto_despacho', // Cambiado de 'monto' a 'monto_despacho'
                'despachos.estado'
            )
            ->get();
    
        return view('logistica.despachos.index', compact('despachos'));
    }
    

    public function create()
    {
        $ventas = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select(
                'ventas.id',
                'ventas.numero_orden',
                'ventas.producto',
                'ventas.created_at as fecha',
                'clientes.nombre as cliente_nombre'
            )
            ->where('ventas.estado', 'nueva')
            ->get();

        return view('logistica.despachos.create', compact('ventas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_despacho' => 'required|string',
            'transporte' => 'required|string',
            'conductor' => 'required|string',
            'monto_despacho' => 'required|numeric',
            'estado' => 'required|string',
            'ordenes' => 'required|array',
        ]);

        $despachoId = DB::table('despachos')->insertGetId([
            'tipo_despacho' => $request->tipo_despacho,
            'transporte' => $request->transporte,
            'conductor' => $request->conductor,
            'monto_despacho' => $request->monto_despacho,
            'estado' => $request->estado,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($request->ordenes as $ordenId) {
            DB::table('ventas_despachos')->insert([
                'despacho_id' => $despachoId,
                'venta_id' => $ordenId,
            ]);

            DB::table('ventas')->where('id', $ordenId)->update(['estado' => 'despachada']);
        }

        return redirect()->route('logistica.despachos.index')->with('success', 'Despacho creado correctamente.');
    }

    public function show($id)
    {
        $despacho = DB::table('despachos')->where('id', $id)->first();

        $ordenes = DB::table('ventas_despachos')
            ->join('ventas', 'ventas_despachos.venta_id', '=', 'ventas.id')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.*', 'clientes.nombre as cliente_nombre')
            ->where('ventas_despachos.despacho_id', $id)
            ->get();

        return view('logistica.despachos.show', compact('despacho', 'ordenes'));
    }

    public function edit($id)
    {
        $despacho = DB::table('despachos')->where('id', $id)->first();

        $ordenesSeleccionadas = DB::table('ventas_despachos')
            ->join('ventas', 'ventas_despachos.venta_id', '=', 'ventas.id')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.*', 'clientes.nombre as cliente_nombre')
            ->where('ventas_despachos.despacho_id', $id)
            ->get();

        $ordenesDisponibles = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.*', 'clientes.nombre as cliente_nombre')
            ->where('ventas.estado', 'nueva')
            ->get();

        return view('logistica.despachos.edit', compact('despacho', 'ordenesSeleccionadas', 'ordenesDisponibles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_despacho' => 'required|string',
            'transporte' => 'required|string',
            'conductor' => 'required|string',
            'monto_despacho' => 'required|numeric',
            'estado' => 'required|string',
            'ordenes' => 'required|array',
        ]);

        DB::table('despachos')->where('id', $id)->update([
            'tipo_despacho' => $request->tipo_despacho,
            'transporte' => $request->transporte,
            'conductor' => $request->conductor,
            'monto_despacho' => $request->monto_despacho,
            'estado' => $request->estado,
            'updated_at' => now(),
        ]);

        DB::table('ventas_despachos')->where('despacho_id', $id)->delete();

        foreach ($request->ordenes as $ordenId) {
            DB::table('ventas_despachos')->insert([
                'despacho_id' => $id,
                'venta_id' => $ordenId,
            ]);

            DB::table('ventas')->where('id', $ordenId)->update(['estado' => 'despachada']);
        }

        return redirect()->route('logistica.despachos.index')->with('success', 'Despacho actualizado correctamente.');
    }

    public function destroy($id)
    {
        DB::table('ventas_despachos')->where('despacho_id', $id)->delete();
        DB::table('despachos')->where('id', $id)->delete();

        return redirect()->route('logistica.despachos.index')->with('success', 'Despacho eliminado correctamente.');
    }
}

