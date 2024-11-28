@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Lista de Despachos</h1>
        <a href="{{ route('logistica.despachos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-plus"></i> Crear Nuevo Despacho
        </a>
    </div>

    <!-- Tabla de despachos -->
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Tipo de Despacho</th>
                <th class="py-3 px-4 text-left">Transporte</th>
                <th class="py-3 px-4 text-left">Conductor</th>
                <th class="py-3 px-4 text-right">Monto</th>
                <th class="py-3 px-4 text-center">Estado</th>
                <th class="py-3 px-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @forelse ($despachos as $despacho)
            <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-4">{{ $despacho->id }}</td>
                <td class="py-3 px-4">{{ ucfirst($despacho->tipo_despacho) }}</td>
                <td class="py-3 px-4">{{ $despacho->transporte }}</td>
                <td class="py-3 px-4">{{ $despacho->conductor }}</td>
                <td class="py-3 px-4 text-right">${{ number_format($despacho->monto_despacho, 2) }}</td>
                <td class="py-3 px-4 text-center">
                    <span class="px-2 py-1 rounded-lg text-white font-bold 
                        @if($despacho->estado === 'pagado') bg-green-500 
                        @else bg-yellow-500 @endif">
                        {{ ucfirst($despacho->estado) }}
                    </span>
                </td>
                <td class="py-3 px-4 text-center flex justify-center space-x-2">
                    <!-- Ver Detalles -->
                    <a href="{{ route('logistica.despachos.show', $despacho->id) }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-eye"></i>
                    </a>
                    <!-- Editar -->
                    <a href="{{ route('logistica.despachos.edit', $despacho->id) }}" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-4 text-center text-gray-500">No hay despachos registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection