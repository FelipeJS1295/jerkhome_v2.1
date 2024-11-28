<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturasComprasController extends Controller
{
    /**
     * Muestra la lista de facturas de compra.
     */
    public function index(Request $request)
    {
        $query = DB::table('facturas_compras')
            ->join('proveedores', 'facturas_compras.proveedor_id', '=', 'proveedores.id')
            ->leftJoin('pagos_facturas', 'facturas_compras.id', '=', 'pagos_facturas.factura_id')
            ->select(
                'facturas_compras.id',
                'facturas_compras.proveedor_id',
                'facturas_compras.fecha',
                'facturas_compras.estado',
                'facturas_compras.numero_documento',
                'proveedores.nombre as proveedor',
                DB::raw('SUM(pagos_facturas.monto) as total_pagado')
            )
            ->groupBy(
                'facturas_compras.id',
                'facturas_compras.proveedor_id',
                'facturas_compras.fecha',
                'facturas_compras.estado',
                'facturas_compras.numero_documento',
                'proveedores.nombre'
            );
    
        // Aplicar filtros
        if ($request->filled('proveedor')) {
            $query->where('facturas_compras.proveedor_id', $request->proveedor);
        }
    
        if ($request->filled('fecha')) {
            $query->whereDate('facturas_compras.fecha', $request->fecha);
        }
    
        if ($request->filled('estado')) {
            $query->where('facturas_compras.estado', $request->estado);
        }
    
        $facturas = $query->get();
    
        // Calcular montos netos y totales para cada factura
        foreach ($facturas as $factura) {
            $insumos = DB::table('factura_insumos')
                ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
                ->select('factura_insumos.cantidad', 'insumos.precio_costo')
                ->where('factura_insumos.factura_id', $factura->id)
                ->get();
    
            // Calcular el monto neto
            $montoNeto = $insumos->sum(function ($insumo) {
                return $insumo->cantidad * $insumo->precio_costo;
            });
    
            // Calcular el monto total (monto neto + IVA)
            $factura->monto_neto = $montoNeto;
            $factura->monto_total = $montoNeto * 1.19; // Agregar 19% de IVA
        }
    
        // Obtener la lista de proveedores para el filtro
        $proveedores = DB::table('proveedores')->select('id', 'nombre')->get();
    
        return view('finanzas.facturas.index', compact('facturas', 'proveedores'));
    }
    
    
    /**
     * Muestra el formulario para crear una nueva factura de compra.
     */
    public function create()
    {
        $proveedores = DB::table('proveedores')->select('id', 'nombre')->get();
        $insumos = DB::table('insumos')->select('id', 'sku_hijo', 'nombre')->get();

        return view('finanzas.facturas.create', compact('proveedores', 'insumos'));
    }

    /**
     * Almacena una nueva factura de compra y sus insumos en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'numero_documento' => 'required|string|max:50',
            'insumos' => 'required|array',
            'insumos.*.id' => 'required|exists:insumos,id',
            'insumos.*.cantidad' => 'required|numeric|min:1',
        ]);

        // Insertar factura en la tabla `facturas_compras`
        $facturaId = DB::table('facturas_compras')->insertGetId([
            'proveedor_id' => $validatedData['proveedor_id'],
            'fecha' => $validatedData['fecha'],
            'numero_documento' => $validatedData['numero_documento'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insertar insumos relacionados en la tabla `factura_insumos`
        foreach ($validatedData['insumos'] as $insumo) {
            DB::table('factura_insumos')->insert([
                'factura_id' => $facturaId,
                'insumo_id' => $insumo['id'],
                'cantidad' => $insumo['cantidad'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('finanzas.facturas.index')->with('success', 'Factura registrada exitosamente.');
    }

    /**
     * Muestra los detalles de una factura de compra.
     */
    public function show($id)
    {
        $factura = DB::table('facturas_compras')
            ->join('proveedores', 'facturas_compras.proveedor_id', '=', 'proveedores.id')
            ->select('facturas_compras.*', 'proveedores.nombre as proveedor')
            ->where('facturas_compras.id', $id)
            ->first();

        if (!$factura) {
            return redirect()->route('finanzas.facturas.index')->with('error', 'Factura no encontrada.');
        }

        $insumosFactura = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.sku_hijo', 'insumos.nombre')
            ->where('factura_insumos.factura_id', $id)
            ->get();

        return view('finanzas.facturas.show', compact('factura', 'insumosFactura'));
    }

    /**
     * Muestra el formulario para editar una factura de compra existente.
     */
    public function edit($id)
    {
        $factura = DB::table('facturas_compras')->where('id', $id)->first();

        if (!$factura) {
            return redirect()->route('finanzas.facturas.index')->with('error', 'Factura no encontrada.');
        }

        $proveedores = DB::table('proveedores')->select('id', 'nombre')->get();
        $insumosFactura = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.sku_hijo', 'insumos.nombre', 'factura_insumos.insumo_id as id')
            ->where('factura_insumos.factura_id', $id)
            ->get();

        return view('finanzas.facturas.edit', compact('factura', 'proveedores', 'insumosFactura'));
    }

    /**
     * Actualiza una factura de compra existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'numero_documento' => 'required|string|max:50',
            'insumos' => 'required|array',
            'insumos.*.id' => 'required|exists:insumos,id',
            'insumos.*.cantidad' => 'required|numeric|min:1',
        ]);

        // Actualizar factura en la tabla `facturas_compras`
        DB::table('facturas_compras')->where('id', $id)->update([
            'proveedor_id' => $validatedData['proveedor_id'],
            'fecha' => $validatedData['fecha'],
            'numero_documento' => $validatedData['numero_documento'],
            'updated_at' => now(),
        ]);

        // Eliminar insumos antiguos relacionados
        DB::table('factura_insumos')->where('factura_id', $id)->delete();

        // Insertar nuevos insumos relacionados
        foreach ($validatedData['insumos'] as $insumo) {
            DB::table('factura_insumos')->insert([
                'factura_id' => $id,
                'insumo_id' => $insumo['id'],
                'cantidad' => $insumo['cantidad'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('finanzas.facturas.index')->with('success', 'Factura actualizada exitosamente.');
    }

    /**
     * Elimina una factura de compra y sus insumos relacionados.
     */
    public function destroy($id)
    {
        DB::table('factura_insumos')->where('factura_id', $id)->delete();
        DB::table('facturas_compras')->where('id', $id)->delete();

        return redirect()->route('finanzas.facturas.index')->with('success', 'Factura eliminada exitosamente.');
    }

    public function pagos($id)
    {
        $factura = DB::table('facturas_compras')
            ->join('proveedores', 'facturas_compras.proveedor_id', '=', 'proveedores.id')
            ->select('facturas_compras.*', 'proveedores.nombre as proveedor')
            ->where('facturas_compras.id', $id)
            ->first();
    
        if (!$factura) {
            return redirect()->route('finanzas.facturas.index')->with('error', 'Factura no encontrada.');
        }
    
        // Calcular montos neto y total
        $insumos = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.precio_costo')
            ->where('factura_insumos.factura_id', $id)
            ->get();
    
        $montoNeto = $insumos->sum(function ($insumo) {
            return $insumo->cantidad * $insumo->precio_costo;
        });
    
        $factura->monto_neto = $montoNeto;
        $factura->monto_total = $montoNeto * 1.19; // Incluye IVA del 19%
    
        // Obtener los pagos realizados
        $pagos = DB::table('pagos_facturas')
            ->where('factura_id', $id)
            ->get();
    
        // Calcular el total pagado
        $totalPagado = $pagos->sum('monto');
    
        return view('finanzas.facturas.pagos', compact('factura', 'pagos', 'totalPagado'));
    }
    
    

    public function registrarPago(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipo_pago' => 'required|in:cheque,transferencia,cuota',
            'monto' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'detalles' => 'nullable|string',
        ]);
    
        // Registrar el pago
        DB::table('pagos_facturas')->insert([
            'factura_id' => $id,
            'tipo_pago' => $validatedData['tipo_pago'],
            'monto' => $validatedData['monto'],
            'fecha_pago' => $validatedData['fecha_pago'],
            'detalles' => $validatedData['detalles'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Calcular el monto total dinámicamente
        $insumos = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.precio_costo')
            ->where('factura_insumos.factura_id', $id)
            ->get();
    
        $montoNeto = $insumos->sum(function ($insumo) {
            return $insumo->cantidad * $insumo->precio_costo;
        });
    
        $montoTotal = $montoNeto * 1.19; // Incluye IVA del 19%
    
        // Verificar el total de pagos realizados
        $pagosTotales = DB::table('pagos_facturas')->where('factura_id', $id)->sum('monto');
    
        // Actualizar el estado de la factura según los pagos realizados
        if ($pagosTotales >= $montoTotal) {
            DB::table('facturas_compras')->where('id', $id)->update(['estado' => 'pagada']);
        } else {
            DB::table('facturas_compras')->where('id', $id)->update(['estado' => 'pendiente documentada']);
        }
    
        return redirect()->route('finanzas.facturas.pagos', $id)->with('success', 'Pago registrado exitosamente.');
    }

    public function eliminarPago($id)
    {
        $pago = DB::table('pagos_facturas')->where('id', $id)->first();

        if (!$pago) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        DB::table('pagos_facturas')->where('id', $id)->delete();

        // Recalcular estado de la factura
        $facturaId = $pago->factura_id;

        $pagosTotales = DB::table('pagos_facturas')->where('factura_id', $facturaId)->sum('monto');
        $insumos = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.precio_costo')
            ->where('factura_insumos.factura_id', $facturaId)
            ->get();

        $montoNeto = $insumos->sum(function ($insumo) {
            return $insumo->cantidad * $insumo->precio_costo;
        });

        $montoTotal = $montoNeto * 1.19;

        $nuevoEstado = $pagosTotales >= $montoTotal ? 'pagada' : 'pendiente documentada';
        DB::table('facturas_compras')->where('id', $facturaId)->update(['estado' => $nuevoEstado]);

        return redirect()->back()->with('success', 'Pago eliminado exitosamente.');
    }

    public function editarPago($id)
    {
        $pago = DB::table('pagos_facturas')->where('id', $id)->first();

        if (!$pago) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        return view('finanzas.facturas.pagos.edit', compact('pago'));
    }

    public function actualizarPago(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipo_pago' => 'required|in:cheque,transferencia,cuota',
            'monto' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'detalles' => 'nullable|string',
        ]);

        $pago = DB::table('pagos_facturas')->where('id', $id)->first();

        if (!$pago) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        DB::table('pagos_facturas')->where('id', $id)->update([
            'tipo_pago' => $validatedData['tipo_pago'],
            'monto' => $validatedData['monto'],
            'fecha_pago' => $validatedData['fecha_pago'],
            'detalles' => $validatedData['detalles'],
            'updated_at' => now(),
        ]);

        // Recalcular estado de la factura
        $facturaId = $pago->factura_id;

        $pagosTotales = DB::table('pagos_facturas')->where('factura_id', $facturaId)->sum('monto');
        $insumos = DB::table('factura_insumos')
            ->join('insumos', 'factura_insumos.insumo_id', '=', 'insumos.id')
            ->select('factura_insumos.cantidad', 'insumos.precio_costo')
            ->where('factura_insumos.factura_id', $facturaId)
            ->get();

        $montoNeto = $insumos->sum(function ($insumo) {
            return $insumo->cantidad * $insumo->precio_costo;
        });

        $montoTotal = $montoNeto * 1.19;

        $nuevoEstado = $pagosTotales >= $montoTotal ? 'pagada' : 'pendiente documentada';
        DB::table('facturas_compras')->where('id', $facturaId)->update(['estado' => $nuevoEstado]);

        return redirect()->route('finanzas.facturas.pagos', $facturaId)->with('success', 'Pago actualizado exitosamente.');
    }


}
