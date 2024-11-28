@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Crédito</h1>

    <form action="{{ route('finanzas.creditos.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf

        <!-- Banco -->
        <div class="mb-4">
            <label for="banco" class="block text-gray-700 font-bold mb-2">Banco</label>
            <select name="banco" id="banco" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="">Seleccione un banco</option>
                @foreach($bancos as $banco)
                <option value="{{ $banco }}">{{ $banco }}</option>
                @endforeach
            </select>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto del Crédito</label>
            <input type="number" name="monto" id="monto" step="0.01" placeholder="Ingrese el monto" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Cuotas -->
        <div class="mb-4">
            <label for="cuotas" class="block text-gray-700 font-bold mb-2">Número de Cuotas</label>
            <input type="number" name="cuotas" id="cuotas" placeholder="Ingrese el número de cuotas" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Tasa de Interés -->
        <div class="mb-4">
            <label for="tasa_interes" class="block text-gray-700 font-bold mb-2">Tasa de Interés (%)</label>
            <input type="number" name="tasa_interes" id="tasa_interes" step="0.01" placeholder="Ingrese la tasa de interés" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Fecha de Inicio -->
        <div class="mb-4">
            <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Botón de Enviar -->
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Registrar Crédito
            </button>
        </div>
    </form>
</div>
@endsection