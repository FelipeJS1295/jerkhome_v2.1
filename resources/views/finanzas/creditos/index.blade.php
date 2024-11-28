@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Listado de Créditos</h1>

    <!-- Botón para registrar un nuevo crédito -->
    <div class="mb-4">
        <a href="{{ route('finanzas.creditos.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus"></i> Registrar Crédito
        </a>
    </div>

    <!-- Tabla de Créditos -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 border border-gray-300 text-left">Banco</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Monto</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Cuotas</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Tasa de Interés (%)</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Monto Total</th>
                    <th class="px-4 py-2 border border-gray-300 text-right">Fecha de Inicio</th>
                    <th class="px-4 py-2 border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($creditos as $credito)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border border-gray-300">{{ $credito->banco }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($credito->monto, 2) }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">{{ $credito->cuotas }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">{{ number_format($credito->tasa_interes, 2) }}%</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($credito->monto_total, 2) }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-right">{{ \Carbon\Carbon::parse($credito->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center">
                        <a href="{{ route('finanzas.creditos.show', $credito->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('finanzas.creditos.edit', $credito->id) }}" class="text-green-500 hover:text-green-700 font-bold ml-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('finanzas.creditos.destroy', $credito->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold" onclick="return confirm('¿Estás seguro de eliminar este crédito?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay créditos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
