@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Lista de Vacaciones</h1>
        <a href="{{ route('rrhh.vacaciones.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-calendar-plus"></i> 
            <span>Registrar Vacaciones</span>
        </a>
    </div>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desde</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($vacaciones as $vacacion)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vacacion->nombres }} {{ $vacacion->apellidos }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vacacion->rut }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vacacion->fecha_desde }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vacacion->fecha_hasta }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($vacacion->estado) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
