@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Horas Extras</h1>
    
    <form action="{{ route('rrhh.horas_extras.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf
        
        <div class="space-y-2">
            <label for="trabajador_id" class="block text-sm font-medium text-gray-700">Trabajador</label>
            <select name="trabajador_id" id="trabajador_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccione un trabajador</option>
                @foreach($trabajadores as $trabajador)
                <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-2">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" name="fecha" id="fecha" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="space-y-2">
            <label for="hora_desde" class="block text-sm font-medium text-gray-700">Hora Desde</label>
            <input type="time" name="hora_desde" id="hora_desde" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="space-y-2">
            <label for="hora_hasta" class="block text-sm font-medium text-gray-700">Hora Hasta</label>
            <input type="time" name="hora_hasta" id="hora_hasta" required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            Registrar
        </button>
    </form>
</div>
@endsection
