@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalles del Gasto Extra</h1>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <!-- Tipo de Gasto -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Tipo de Gasto</h2>
            <p class="text-gray-700">{{ $gasto->tipo_gasto }}</p>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Fecha</h2>
            <p class="text-gray-700">{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</p>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Monto</h2>
            <p class="text-gray-700">${{ number_format($gasto->monto, 2) }}</p>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Estado</h2>
            <p class="text-gray-700">{{ $gasto->estado }}</p>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Descripción</h2>
            <p class="text-gray-700">{{ $gasto->descripcion ?? 'N/A' }}</p>
        </div>

        <!-- Botón para Regresar -->
        <div class="text-center">
            <a href="{{ route('finanzas.gastos.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 focus:ring focus:ring-gray-300">
                Volver a la Lista
            </a>
        </div>
    </div>
</div>
@endsection
