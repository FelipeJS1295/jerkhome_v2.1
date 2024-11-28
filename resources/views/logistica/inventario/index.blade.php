@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Inventario</h1>

        <!-- Botón para ir al análisis de inventario de ventas -->
        <div class="mb-4">
            <a href="{{ route('logistica.inventario.ventas') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
                <i class="fas fa-chart-bar"></i> Inventario ventas
            </a>
        </div>

    <!-- Tabla de Inventario -->
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">SKU</th>
                <th class="py-3 px-4 text-left">Nombre</th>
                <th class="py-3 px-4 text-right">Cantidad Total</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @forelse($inventario as $item)
            <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-4">{{ $item->sku_hijo }}</td>
                <td class="py-3 px-4">{{ $item->nombre }}</td>
                <td class="py-3 px-4 text-right">{{ $item->cantidad_total }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="py-4 text-center text-gray-500">No hay registros de inventario.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
