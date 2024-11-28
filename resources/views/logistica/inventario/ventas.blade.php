@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Resumen de Inventario por Ventas</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('logistica.inventario.ventas') }}" class="mb-6 flex items-center space-x-4">
        <input type="text" name="producto" value="{{ old('producto', $filtroProducto ?? '') }}"
               placeholder="Buscar por producto..."
               class="w-1/3 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-search"></i> Buscar
        </button>
        <a href="{{ route('logistica.inventario.dashboard') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            <i class="fas fa-chart-bar"></i> Ir al Dashboard de Análisis
        </a>
    </form>

    @if ($resumen->isEmpty())
        <div class="text-gray-600 text-center">
            <p>No se encontraron datos para mostrar. Intenta ajustar los filtros.</p>
        </div>
    @else
        @foreach ($resumen as $producto => $insumos)
        <div class="mb-6 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">{{ $producto }}</h2>
            <p class="text-gray-600 mb-4">
                <span class="font-bold">Órdenes Totales:</span> {{ $insumos->first()->ordenes_nuevas + $insumos->first()->ordenes_despachadas }}<br>
                <span class="font-bold">Órdenes Nuevas:</span> {{ $insumos->first()->ordenes_nuevas }}<br>
                <span class="font-bold">Órdenes Despachadas:</span> {{ $insumos->first()->ordenes_despachadas }}
            </p>

            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">SKU Insumo</th>
                        <th class="py-3 px-4 text-left">Insumo</th>
                        <th class="py-3 px-4 text-right">Stock</th>
                        <th class="py-3 px-4 text-right">Cantidad Usada</th>
                        <th class="py-3 px-4 text-right">Cantidad a Usar</th>
                        <th class="py-3 px-4 text-right">Faltante</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($insumos as $insumo)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $insumo->sku }}</td>
                        <td class="py-3 px-4">{{ $insumo->insumo }}</td>
                        <td class="py-3 px-4 text-right">{{ $insumo->stock }}</td>
                        <td class="py-3 px-4 text-right">{{ $insumo->cantidad_usada }}</td>
                        <td class="py-3 px-4 text-right">{{ $insumo->cantidad_a_usar }}</td>
                        <td class="py-3 px-4 text-right {{ $insumo->faltante > 0 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $insumo->faltante }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    @endif
</div>
@endsection