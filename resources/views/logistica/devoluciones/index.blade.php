@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Devoluciones</h1>

    <!-- Submenú -->
    <div class="mb-6 flex space-x-4">
        <a href="{{ route('logistica.devoluciones.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-filter"></i> Devoluciones con Filtros
        </a>
        <a href="{{ route('logistica.devoluciones.todas') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            <i class="fas fa-list"></i> Todas las Devoluciones
        </a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('logistica.devoluciones.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-4">
        <input type="text" name="cliente" value="{{ old('cliente', $filtroCliente) }}"
               placeholder="Buscar por cliente..."
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <input type="text" name="orden" value="{{ old('orden', $filtroOrden) }}"
               placeholder="Buscar por orden..."
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <input type="text" name="producto" value="{{ old('producto', $filtroProducto) }}"
               placeholder="Buscar por producto..."
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <select name="estado" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
            <option value="">Estado</option>
            <option value="nueva" {{ $filtroEstado === 'nueva' ? 'selected' : '' }}>Nueva</option>
            <option value="despachada" {{ $filtroEstado === 'despachada' ? 'selected' : '' }}>Despachada</option>
            <option value="devolucion" {{ $filtroEstado === 'devolucion' ? 'selected' : '' }}>Devolución</option>
        </select>
        <input type="date" name="fecha" value="{{ old('fecha', $filtroFecha) }}"
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-search"></i> Buscar
        </button>
        <a href="{{ route('logistica.devoluciones.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-times"></i> Limpiar Filtros
        </a>
    </form>

    <!-- Mensajes -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 border border-green-400 rounded-lg p-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-100 text-red-700 border border-red-400 rounded-lg p-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabla de ventas -->
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">Cliente</th>
                <th class="py-3 px-4 text-left">Número de Orden</th>
                <th class="py-3 px-4 text-left">Fecha</th>
                <th class="py-3 px-4 text-left">SKU</th>
                <th class="py-3 px-4 text-left">Producto</th>
                <th class="py-3 px-4 text-center">Estado</th>
                <th class="py-3 px-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @forelse ($ventas as $venta)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-4">{{ $venta->cliente_nombre }}</td>
                    <td class="py-3 px-4">{{ $venta->numero_orden }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ $venta->sku }}</td>
                    <td class="py-3 px-4">{{ $venta->producto }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-lg text-white font-bold
                            @if($venta->estado === 'despachada') bg-green-500
                            @elseif($venta->estado === 'nueva') bg-yellow-500
                            @elseif($venta->estado === 'devolucion') bg-red-500
                            @else bg-blue-500 @endif">
                            {{ ucfirst($venta->estado) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if ($venta->estado !== 'devolucion')
                            <form action="{{ route('logistica.devoluciones.cambiarEstado', $venta->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                    Marcar como Devolución
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500">Sin Acciones</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-4 text-center text-gray-500">No hay ventas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
