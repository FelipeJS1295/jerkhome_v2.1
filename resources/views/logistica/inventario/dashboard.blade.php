@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard de Análisis de Inventario</h1>

            <!-- Botón para ir al análisis de inventario de ventas -->
        <div class="mb-4">
            <a href="{{ route('logistica.inventario.ventas') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
                <i class="fas fa-chart-bar"></i> Inventario ventas
            </a>
        </div>

    <!-- Resumen general -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Insumos Totales</h2>
            <p class="text-3xl font-bold text-blue-500">{{ $totales['total_insumos'] }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Productos con Stock Crítico</h2>
            <p class="text-3xl font-bold text-red-500">{{ $totales['stock_critico'] }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Total Órdenes Nuevas</h2>
            <p class="text-3xl font-bold text-green-500">{{ $totales['ordenes_nuevas'] }}</p>
        </div>
    </div>

    <!-- Tabla de análisis por insumo -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Análisis Detallado de Insumos</h2>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-left">SKU Insumo</th>
                    <th class="py-3 px-4 text-left">Insumo</th>
                    <th class="py-3 px-4 text-right">Stock Disponible</th>
                    <th class="py-3 px-4 text-right">Consumo Actual (Mes)</th>
                    <th class="py-3 px-4 text-right">Proyección Futura</th>
                    <th class="py-3 px-4 text-right">Faltante</th>
                    <th class="py-3 px-4 text-center">Estado</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($insumos as $insumo)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-4">{{ $insumo->sku_hijo }}</td>
                    <td class="py-3 px-4">{{ $insumo->nombre }}</td>
                    <td class="py-3 px-4 text-right">{{ $insumo->stock_disponible }}</td>
                    <td class="py-3 px-4 text-right">{{ $insumo->consumo_actual }}</td>
                    <td class="py-3 px-4 text-right">{{ $insumo->proyeccion_futura }}</td>
                    <td class="py-3 px-4 text-right {{ $insumo->faltante > 0 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $insumo->faltante }}
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-lg font-bold text-white
                            {{ $insumo->es_critico ? 'bg-red-500' : 'bg-green-500' }}">
                            {{ $insumo->es_critico ? 'Crítico' : 'Adecuado' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection