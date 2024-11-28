<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticaController extends Controller
{
    /**
     * Mostrar la vista principal de Logística.
     */
    public function index()
    {
        return view('logistica.index');
    }

    /**
     * Mostrar la lista de devoluciones.
     */
    public function devolucionesIndex(Request $request)
    {
        $filtroCliente = $request->input('cliente');
        $filtroOrden = $request->input('orden');
        $filtroProducto = $request->input('producto');
        $filtroEstado = $request->input('estado');
        $filtroFecha = $request->input('fecha');
    
        $ventas = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id') // Join con clientes
            ->join('productos', 'ventas.producto', '=', 'productos.nombre') // Join con productos
            ->select(
                'ventas.id',
                'clientes.nombre as cliente_nombre',
                'ventas.numero_orden',
                'ventas.fecha_compra as fecha',
                'ventas.estado',
                'productos.sku as sku',
                'productos.nombre as producto'
            )
            // Aplicamos los filtros
            ->when($filtroCliente, function ($query, $filtroCliente) {
                return $query->where('clientes.nombre', 'LIKE', "%{$filtroCliente}%");
            })
            ->when($filtroOrden, function ($query, $filtroOrden) {
                return $query->where('ventas.numero_orden', 'LIKE', "%{$filtroOrden}%");
            })
            ->when($filtroProducto, function ($query, $filtroProducto) {
                return $query->where('productos.nombre', 'LIKE', "%{$filtroProducto}%");
            })
            ->when($filtroEstado, function ($query, $filtroEstado) {
                return $query->where('ventas.estado', $filtroEstado);
            })
            ->when($filtroFecha, function ($query, $filtroFecha) {
                return $query->whereDate('ventas.fecha_compra', '=', $filtroFecha);
            })
            ->get();
    
        return view('logistica.devoluciones.index', compact('ventas', 'filtroCliente', 'filtroOrden', 'filtroProducto', 'filtroEstado', 'filtroFecha'));
    }
    
    
    /**
     * Cambiar el estado de una orden a 'devolucion'.
     */
    public function cambiarEstadoDevolucion(Request $request, $id)
    {
        // Validar que la venta existe
        $venta = DB::table('ventas')->where('id', $id)->first();
        if (!$venta) {
            return redirect()->route('logistica.devoluciones.index')->with('error', 'La venta no existe.');
        }
    
        // Cambiar el estado de la venta a "devolución"
        DB::table('ventas')
            ->where('id', $id)
            ->update(['estado' => 'devolucion']);
    
        return redirect()->route('logistica.devoluciones.index')->with('success', 'El estado de la orden se cambió a "Devolución".');
    }
    
    public function devolucionesTodas(Request $request)
    {
        // Filtros
        $filtroCliente = $request->input('cliente');
        $filtroOrden = $request->input('orden');
        $filtroProducto = $request->input('producto');
    
        // Consulta con filtros
        $devoluciones = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->join('productos', 'ventas.producto', '=', 'productos.nombre')
            ->select(
                'ventas.id',
                'clientes.nombre as cliente_nombre',
                'ventas.numero_orden',
                'ventas.fecha_compra as fecha',
                'ventas.estado',
                'productos.sku as sku',
                'productos.nombre as producto'
            )
            ->where('ventas.estado', 'devolucion')
            ->when($filtroCliente, function ($query, $filtroCliente) {
                return $query->where('clientes.nombre', 'LIKE', "%{$filtroCliente}%");
            })
            ->when($filtroOrden, function ($query, $filtroOrden) {
                return $query->where('ventas.numero_orden', 'LIKE', "%{$filtroOrden}%");
            })
            ->when($filtroProducto, function ($query, $filtroProducto) {
                return $query->where('productos.nombre', 'LIKE', "%{$filtroProducto}%");
            })
            ->get();
    
        return view('logistica.devoluciones.todas', compact('devoluciones'));
    }
    


    /**
     * Mostrar la lista de inventario.
     */
    public function inventarioIndex()
    {
        // Consulta los datos de inventario
        $inventario = DB::table('insumos')
            ->join('factura_insumos', 'insumos.id', '=', 'factura_insumos.insumo_id')
            ->select(
                'insumos.id',
                'insumos.sku_hijo',
                'insumos.nombre',
                DB::raw('SUM(factura_insumos.cantidad) as cantidad_total')
            )
            ->groupBy('insumos.id', 'insumos.sku_hijo', 'insumos.nombre')
            ->get();
    
        return view('logistica.inventario.index', compact('inventario'));
    }
    

    /**
     * Mostrar la lista de despachos.
     */
    public function despachosIndex()
    {
        // Aquí puedes obtener datos de despachos desde la base de datos.
        // $despachos = DB::table('despachos')->get();
        return view('logistica.despachos.index'); // Compactar despachos si es necesario.
    }

    public function inventarioVentas(Request $request)
    {
        $filtroProducto = $request->input('producto');

        $ventas = DB::table('ventas')
            ->join('productos', 'ventas.producto', '=', 'productos.nombre')
            ->join('producto_insumo', 'productos.id', '=', 'producto_insumo.producto_id')
            ->join('insumos', 'producto_insumo.insumo_id', '=', 'insumos.id')
            ->leftJoin('factura_insumos', 'insumos.id', '=', 'factura_insumos.insumo_id')
            ->select(
                'productos.nombre as producto',
                'insumos.id as insumo_id',
                'insumos.nombre as insumo',
                'insumos.sku_hijo as sku',
                'insumos.unidad_medida',
                DB::raw('SUM(CASE WHEN ventas.estado = "nueva" THEN ventas.unidades ELSE 0 END) as ordenes_nuevas'),
                DB::raw('SUM(CASE WHEN ventas.estado = "despachada" THEN ventas.unidades ELSE 0 END) as ordenes_despachadas'),
                DB::raw('SUM(CASE WHEN ventas.estado = "despachada" THEN producto_insumo.cantidad * ventas.unidades ELSE 0 END) as cantidad_usada'),
                DB::raw('SUM(CASE WHEN ventas.estado = "nueva" THEN producto_insumo.cantidad * ventas.unidades ELSE 0 END) as cantidad_a_usar'),
                DB::raw('SUM(factura_insumos.cantidad) as stock')
            )
            ->when($filtroProducto, function ($query, $filtroProducto) {
                return $query->where('productos.nombre', 'LIKE', "%{$filtroProducto}%");
            })
            ->groupBy('productos.nombre', 'insumos.id', 'insumos.nombre', 'insumos.sku_hijo', 'insumos.unidad_medida')
            ->get();

        foreach ($ventas as $venta) {
            $venta->faltante = max(0, $venta->cantidad_a_usar - $venta->stock);

            if (in_array($venta->unidad_medida, ['metros', 'litros', 'kilogramos'])) {
                $venta->cantidad_usada = number_format($venta->cantidad_usada, 2);
                $venta->cantidad_a_usar = number_format($venta->cantidad_a_usar, 2);
                $venta->faltante = number_format($venta->faltante, 2);
                $venta->stock = number_format($venta->stock, 2);
            } else {
                $venta->cantidad_usada = intval($venta->cantidad_usada);
                $venta->cantidad_a_usar = intval($venta->cantidad_a_usar);
                $venta->faltante = intval($venta->faltante);
                $venta->stock = intval($venta->stock);
            }
        }

        $resumen = $ventas->groupBy('producto');

        return view('logistica.inventario.ventas', compact('resumen', 'filtroProducto'));
    }

    public function dashboard()
    {
        $currentMonth = now()->format('Y-m');
    
        // 1. Obtener datos de insumos con stock disponible
        $insumos = DB::table('insumos')
            ->leftJoin('factura_insumos', 'insumos.id', '=', 'factura_insumos.insumo_id')
            ->select(
                'insumos.id',
                'insumos.nombre',
                'insumos.sku_hijo',
                DB::raw('SUM(factura_insumos.cantidad) as total_comprado')
            )
            ->groupBy('insumos.id', 'insumos.nombre', 'insumos.sku_hijo')
            ->get();
    
        $stockCritico = 0;
    
        foreach ($insumos as $insumo) {
            // 2. Calcular consumo actual del mes según ventas despachadas
            $consumoActual = DB::table('ventas')
                ->join('producto_insumo', 'ventas.producto', '=', 'producto_insumo.producto_id')
                ->where('ventas.estado', 'despachada')
                ->where('producto_insumo.insumo_id', $insumo->id)
                ->whereMonth('ventas.fecha_compra', now()->month)
                ->whereYear('ventas.fecha_compra', now()->year)
                ->sum(DB::raw('ventas.unidades * producto_insumo.cantidad'));
    
            // 3. Calcular proyección futura de ventas en estado nueva
            $proyeccionFutura = DB::table('ventas')
                ->join('producto_insumo', 'ventas.producto', '=', 'producto_insumo.producto_id')
                ->where('ventas.estado', 'nueva')
                ->where('producto_insumo.insumo_id', $insumo->id)
                ->sum(DB::raw('ventas.unidades * producto_insumo.cantidad'));
    
            // 4. Actualizar stock disponible descontando consumo actual
            $stockDisponible = $insumo->total_comprado - $consumoActual;
    
            // 5. Calcular faltante para las proyecciones futuras
            $faltante = max(0, $proyeccionFutura - $stockDisponible);
    
            // 6. Identificar si está en estado crítico
            $esCritico = $stockDisponible <= 50;
    
            $insumo->consumo_actual = $consumoActual;
            $insumo->proyeccion_futura = $proyeccionFutura;
            $insumo->stock_disponible = $stockDisponible;
            $insumo->faltante = $faltante;
            $insumo->es_critico = $esCritico;
    
            if ($esCritico) {
                $stockCritico++;
            }
        }
    
        // Resumen general
        $totales = [
            'total_insumos' => count($insumos),
            'stock_critico' => $stockCritico,
            'ordenes_nuevas' => DB::table('ventas')->where('estado', 'nueva')->count(),
        ];
    
        return view('logistica.inventario.dashboard', compact('insumos', 'totales'));
    }

}