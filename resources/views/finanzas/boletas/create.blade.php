@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Boleta Extra</h1>

    <form action="{{ route('finanzas.boletas.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf

        <!-- Trabajador -->
        <div class="mb-4">
            <label for="trabajador_id" class="block text-gray-700 font-bold mb-2">Trabajador</label>
            <select name="trabajador_id" id="trabajador_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="">Seleccione un trabajador</option>
                @foreach($trabajadores as $trabajador)
                <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <!-- Número de Boleta -->
        <div class="mb-4">
            <label for="numero_boleta" class="block text-gray-700 font-bold mb-2">Número de Boleta</label>
            <input type="text" name="numero_boleta" id="numero_boleta" placeholder="Ingrese el número de la boleta"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" placeholder="Ingrese una descripción de la compra"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required></textarea>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" id="monto" step="0.01" placeholder="Ingrese el monto de la boleta"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Botón de Enviar -->
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Registrar Boleta
            </button>
        </div>
    </form>
</div>
@endsection
