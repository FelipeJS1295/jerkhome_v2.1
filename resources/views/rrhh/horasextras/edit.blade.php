@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Horas Extras</h1>
    
    <form action="{{ route('rrhh.horas_extras.update', $horaExtra->id) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-2">
            <label for="trabajador_id" class="block text-sm font-medium text-gray-700">Trabajador</label>
            <select name="trabajador_id" id="trabajador_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccione un trabajador</option>
                @foreach($trabajadores as $trabajador)
                <option value="{{ $trabajador->id }}" {{ $trabajador->id == $horaExtra->trabajador_id ? 'selected' : '' }}>
                    {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-2">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ $horaExtra->fecha }}" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="space-y-2">
            <label for="hora_desde" class="block text-sm font-medium text-gray-700">Hora Desde</label>
            <input type="time" name="hora_desde" id="hora_desde" value="{{ $horaExtra->hora_desde }}" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="space-y-2">
            <label for="hora_hasta" class="block text-sm font-medium text-gray-700">Hora Hasta</label>
            <input type="time" name="hora_hasta" id="hora_hasta" value="{{ $horaExtra->hora_hasta }}" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
            Actualizar
        </button>
    </form>
</div>
@endsection
