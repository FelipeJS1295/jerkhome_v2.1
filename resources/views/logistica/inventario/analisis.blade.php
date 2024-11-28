@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Análisis de Inventario</h1>

    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">SKU</th>
                <th class="py-3 px-4 text-left">Nombre</th>
                <th class="py-3 px-4 text-right">Total Comprado</th>
                <th class="py-3 px-4 text-right">Consumo Actual</th>
                <th class="py-3 px-4 text-right">Proyección Futura</th>
                <th class="py-3 px-4 text-right">Stock Disponible</th>
                <th class="py-3 px-4 text-right">Faltante</th>
                <th class="py-3 px-4 text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($insumos as $insumo)
            <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-4">{{ $insumo->sku_hijo }}</td>
                <td class="py-3 px-4">{{ $insumo->nombre }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($insumo->total_comprado, 2) }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($insumo->consumo_actual, 2) }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($insumo->proyeccion_futura, 2) }}</td>
                <td class="py-3 px-4 text-right {{ $insumo->es_critico ? 'text-red-500' : 'text-gray-800' }}">
                    {{ number_format($insumo->stock_disponible, 2) }}
                </td>
                <td class="py-3 px-4 text-right">{{ number_format($insumo->faltante, 2) }}</td>
                <td class="py-3 px-4 text-center">
                    @if($insumo->es_critico)
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full">Crítico</span>
                    @else
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full">Ok</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
