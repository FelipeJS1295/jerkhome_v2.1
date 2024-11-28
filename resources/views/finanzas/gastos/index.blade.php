@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gastos Extras</h1>

    <!-- Botón para registrar un nuevo gasto -->
    <div class="mb-4">
        <a href="{{ route('finanzas.gastos.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus"></i> Registrar Gasto
        </a>
    </div>

    <!-- Tabla de Gastos -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 border border-gray-300 text-left">Tipo de Gasto</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Fecha</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Monto</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Estado</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Descripción</th>
                    <th class="px-4 py-2 border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($gastos as $gasto)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border border-gray-300">{{ $gasto->tipo_gasto }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($gasto->monto, 2) }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $gasto->estado }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $gasto->descripcion ?? 'N/A' }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center">
                        <!-- Ver -->
                        <a href="{{ route('finanzas.gastos.show', $gasto->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <!-- Editar -->
                        <a href="{{ route('finanzas.gastos.edit', $gasto->id) }}" class="text-green-500 hover:text-green-700 font-bold ml-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <!-- Eliminar -->
                        <form action="{{ route('finanzas.gastos.destroy', $gasto->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold" onclick="return confirm('¿Estás seguro de eliminar este gasto?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay gastos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
