@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Boletas Extras</h1>

    <!-- Botón para registrar nueva boleta -->
    <div class="mb-4">
        <a href="{{ route('finanzas.boletas.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus"></i> Registrar Boleta
        </a>
    </div>

    <!-- Tabla de Boletas -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 border border-gray-300 text-left">Trabajador</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Número de Boleta</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Descripción</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Monto</th>
                    <th class="px-4 py-2 border border-gray-300 text-center">Fecha</th>
                    <th class="px-4 py-2 border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($boletas as $boleta)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border border-gray-300">{{ $boleta->nombres }} {{ $boleta->apellidos }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $boleta->numero_boleta }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $boleta->descripcion }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($boleta->monto, 2) }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ \Carbon\Carbon::parse($boleta->created_at)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center">
                        <!-- Acción Ver -->
                        <a href="{{ route('finanzas.boletas.show', $boleta->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <!-- Acción Editar -->
                        <a href="{{ route('finanzas.boletas.edit', $boleta->id) }}" class="text-green-500 hover:text-green-700 font-bold ml-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <!-- Acción Eliminar -->
                        <form action="{{ route('finanzas.boletas.destroy', $boleta->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold" onclick="return confirm('¿Estás seguro de eliminar esta boleta?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay boletas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
