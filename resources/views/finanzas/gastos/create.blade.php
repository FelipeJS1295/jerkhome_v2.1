@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Gasto Extra</h1>

    <form action="{{ route('finanzas.gastos.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf

        <!-- Tipo de Gasto -->
        <div class="mb-4">
            <label for="tipo_gasto" class="block text-gray-700 font-bold mb-2">Tipo de Gasto</label>
            <select name="tipo_gasto" id="tipo_gasto" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="">Seleccione un tipo</option>
                <option value="Luz">Luz</option>
                <option value="Agua">Agua</option>
                <option value="Arriendo">Arriendo</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" id="monto" step="0.01" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-bold mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="Pagado">Pagado</option>
                <option value="Pendiente">Pendiente</option>
            </select>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" placeholder="Opcional"></textarea>
        </div>

        <!-- Botón de Enviar -->
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Registrar Gasto
            </button>
        </div>
    </form>
</div>
@endsection
