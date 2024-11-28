@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Planilla de Horas Extras</h1>
        <a href="{{ route('rrhh.horas_extras.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i> Registrar Horas Extras
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desde</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Horas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($horasExtras as $horaExtra)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $horaExtra->nombres }} {{ $horaExtra->apellidos }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $horaExtra->rut }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $horaExtra->fecha }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $horaExtra->hora_desde }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $horaExtra->hora_hasta }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $horaExtra->horas_totales }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('rrhh.horas_extras.edit', $horaExtra->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition-colors">Editar</a>
                        <form action="{{ route('rrhh.horas_extras.destroy', $horaExtra->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
