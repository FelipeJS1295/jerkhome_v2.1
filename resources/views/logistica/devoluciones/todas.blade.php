@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Todas las Devoluciones</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('logistica.devoluciones.todas') }}" class="mb-6 flex items-center space-x-4">
        <input type="text" name="cliente" value="{{ request('cliente') }}"
               placeholder="Buscar por cliente..."
               class="w-1/4 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <input type="text" name="orden" value="{{ request('orden') }}"
               placeholder="Buscar por número de orden..."
               class="w-1/4 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <input type="text" name="producto" value="{{ request('producto') }}"
               placeholder="Buscar por producto..."
               class="w-1/4 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-search"></i> Buscar
        </button>
        <a href="{{ route('logistica.devoluciones.todas') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-redo"></i> Limpiar Filtros
        </a>
        <a href="{{ route('logistica.devoluciones.index') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </form>

    <!-- Tabla -->
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">Cliente</th>
                <th class="py-3 px-4 text-left">Número de Orden</th>
                <th class="py-3 px-4 text-left">Fecha</th>
                <th class="py-3 px-4 text-left">SKU</th>
                <th class="py-3 px-4 text-left">Producto</th>
                <th class="py-3 px-4 text-center">Estado</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @forelse ($devoluciones as $devolucion)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-4">{{ $devolucion->cliente_nombre }}</td>
                    <td class="py-3 px-4">{{ $devolucion->numero_orden }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($devolucion->fecha)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ $devolucion->sku }}</td>
                    <td class="py-3 px-4">{{ $devolucion->producto }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-lg text-white font-bold bg-red-500">
                            Devolución
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 text-center text-gray-500">No hay devoluciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
