<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const NOMBRES_REGIONES = [
        'XV' => 'Arica y Parinacota',
        'I' => 'Tarapacá',
        'II' => 'Antofagasta',
        'III' => 'Atacama',
        'IV' => 'Coquimbo',
        'V' => 'Valparaíso',
        'RM' => 'Metropolitana',
        'VI' => 'O\'Higgins',
        'VII' => 'Maule',
        'XVI' => 'Ñuble',
        'VIII' => 'Biobío',
        'IX' => 'Araucanía',
        'XIV' => 'Los Ríos',
        'X' => 'Los Lagos',
        'XI' => 'Aysén',
        'XII' => 'Magallanes',
    ];

    public function index()
    {
        $now = Carbon::now();

        $ventasMensuales = $this->getVentasMensuales($now);
        $ventasMesActual = $this->getVentasMesActual($now);
        $ventasTotales = $this->getVentasTotales();
        $ventasRegion = $this->getVentasRegion();
        $totalSueldos = $this->getTotalSueldos();
        $proyeccion = $this->getProyeccion($ventasMensuales);
        $topProductos = $this->getTopProductos();
        $ventasMensuales = $this->getVentasMensuales($now);
        $ventasMesActual = $this->getVentasMesActual($now);

        return view('dashboard', compact(
            'ventasMensuales',
            'ventasMesActual',
            'ventasTotales',
            'ventasRegion',
            'totalSueldos',
            'proyeccion',
            'topProductos'
        ));
    }

    private function getVentasMensuales($now)
    {
        return DB::table('ventas')
            ->select(
                DB::raw('MONTH(fecha_compra) as mes'),
                DB::raw('SUM(
                    CASE 
                        WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                        WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                        WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                        WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                        WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                        ELSE precio_cliente
                    END
                ) as total'),
                DB::raw('SUM(unidades) as unidades')
            )
            ->whereYear('fecha_compra', $now->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
    }

    private function getVentasMesActual($now)
    {
        return DB::table('ventas')
            ->select(
                DB::raw('SUM(
                    CASE 
                        WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                        WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                        WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                        WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                        WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                        ELSE precio_cliente
                    END
                ) as total'),
                DB::raw('SUM(unidades) as unidades')
            )
            ->whereYear('fecha_compra', $now->year)
            ->whereMonth('fecha_compra', $now->month)
            ->first();
    }

    private function getVentasTotales()
    {
        return DB::table('ventas')
            ->select(
                DB::raw('SUM(
                    CASE 
                        WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                        WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                        WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                        WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                        WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                        ELSE precio_cliente
                    END
                ) as total'),
                DB::raw('SUM(unidades) as unidades')
            )
            ->first();
    }

    private function getVentasRegion()
    {
        $totalVentas = DB::table('ventas')->sum('precio_cliente');

        $ventasPorRegion = DB::table('ventas')
            ->select(
                'region',
                DB::raw('SUM(precio_cliente) as monto'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('region')
            ->groupBy('region')
            ->get();

        return $ventasPorRegion->map(function ($item) use ($totalVentas) {
            $porcentaje = $totalVentas > 0 ? ($item->monto / $totalVentas) * 100 : 0;

            return (object)[
                'region' => self::NOMBRES_REGIONES[$item->region] ?? $item->region,
                'monto' => $item->monto,
                'total' => $item->total,
                'porcentaje' => round($porcentaje, 2),
            ];
        });
    }

    private function getTotalSueldos()
    {
        return DB::table('trabajadores')->sum('sueldo');
    }

    private function getProyeccion($ventasMensuales)
    {
        if ($ventasMensuales->isEmpty()) {
            return collect();
        }

        $promedioVentas = $ventasMensuales->avg('total');
        $ultimoMes = $ventasMensuales->last();
        $primerMes = $ventasMensuales->first();

        $crecimientoPorcentual = $primerMes->total > 0 ?
            (($ultimoMes->total - $primerMes->total) / $primerMes->total) : 0;

        return collect(range(1, 3))->map(function ($mes) use ($promedioVentas, $crecimientoPorcentual) {
            $proyeccionMonto = $promedioVentas * (1 + ($crecimientoPorcentual * $mes));

            return [
                'mes' => Carbon::now()->addMonths($mes)->format('M'),
                'proyeccion' => round($proyeccionMonto, 2),
                'crecimiento' => round($crecimientoPorcentual * 100, 2),
            ];
        });
    }

    private function getTopProductos()
    {
        $now = Carbon::now();
    
        return DB::table('ventas')
            ->select(
                'producto',
                DB::raw('SUM(CASE WHEN MONTH(fecha_compra) = ' . $now->month . ' THEN unidades ELSE 0 END) as unidades_mes'),
                DB::raw('SUM(unidades) as unidades_totales'),
                DB::raw('SUM(
                    CASE 
                        WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                        WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                        WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                        WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                        WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                        ELSE precio_cliente
                    END
                ) as precio_total')
            )
            ->groupBy('producto')
            ->orderByDesc('unidades_totales')
            ->limit(5)
            ->get();
    }

    private function getVentasPorRegion()
    {
        $totalVentas = DB::table('ventas')
            ->sum(DB::raw("
                CASE 
                    WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                    WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                    WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                    WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                    WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                    ELSE precio_cliente
                END
            "));

        $ventasPorRegion = DB::table('ventas')
            ->select(
                'region',
                DB::raw("
                    SUM(
                        CASE 
                            WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                            WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                            WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                            WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                            WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                            ELSE precio_cliente
                        END
                    ) as monto
                "),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('region')
            ->groupBy('region')
            ->get();

        return $ventasPorRegion->map(function ($item) use ($totalVentas) {
            $porcentaje = $totalVentas > 0 ? ($item->monto / $totalVentas) * 100 : 0;

            return (object)[
                'region' => self::NOMBRES_REGIONES[$item->region] ?? $item->region,
                'monto' => $item->monto,
                'total' => $item->total,
                'porcentaje' => round($porcentaje, 2),
            ];
        });
    }

    private function getProductosMasVendidos()
    {
        return DB::table('ventas')
            ->select(
                'producto',
                DB::raw("
                    SUM(unidades) as unidades_mes,
                    SUM(
                        CASE 
                            WHEN cliente_id = 2 THEN unidades
                            WHEN cliente_id = 3 THEN unidades
                            WHEN cliente_id = 4 THEN unidades
                            WHEN cliente_id = 5 THEN unidades
                            WHEN cliente_id = 6 THEN unidades
                            ELSE unidades
                        END
                    ) as unidades_totales,
                    SUM(
                        CASE 
                            WHEN cliente_id = 2 THEN precio_cliente * 0.84 - 8990
                            WHEN cliente_id = 3 THEN precio_cliente * 0.88 - 12990
                            WHEN cliente_id = 4 THEN precio_cliente * 0.80 - 18990
                            WHEN cliente_id = 5 THEN precio_cliente * 0.99 - 18990
                            WHEN cliente_id = 6 THEN precio_cliente * 0.80 - 16990
                            ELSE precio_cliente
                        END
                    ) as precio_cliente
                ")
            )
            ->groupBy('producto')
            ->orderByDesc('unidades_totales')
            ->limit(10)
            ->get();
    }
}