@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalles de la Boleta</h1>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <!-- Información del Trabajador -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Trabajador</h2>
            <p class="text-gray-700">{{ $boleta->nombres }} {{ $boleta->apellidos }}</p>
        </div>

        <!-- Número de Boleta -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Número de Boleta</h2>
            <p class="text-gray-700">{{ $boleta->numero_boleta }}</p>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Descripción</h2>
            <p class="text-gray-700">{{ $boleta->descripcion }}</p>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Monto</h2>
            <p class="text-gray-700">${{ number_format($boleta->monto, 2) }}</p>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Fecha de Registro</h2>
            <p class="text-gray-700">{{ \Carbon\Carbon::parse($boleta->created_at)->format('d/m/Y') }}</p>
        </div>

        <!-- Botón para Regresar -->
        <div class="text-center">
            <a href="{{ route('finanzas.boletas.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 focus:ring focus:ring-gray-300">
                Volver a la Lista
            </a>
        </div>
    </div>
</div>
@endsection
