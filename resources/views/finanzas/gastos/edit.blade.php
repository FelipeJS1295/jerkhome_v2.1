@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Gasto Extra</h1>

    <form action="{{ route('finanzas.gastos.update', $gasto->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <!-- Tipo de Gasto -->
        <div class="mb-4">
            <label for="tipo_gasto" class="block text-gray-700 font-bold mb-2">Tipo de Gasto</label>
            <select name="tipo_gasto" id="tipo_gasto" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="Luz" {{ $gasto->tipo_gasto == 'Luz' ? 'selected' : '' }}>Luz</option>
                <option value="Agua" {{ $gasto->tipo_gasto == 'Agua' ? 'selected' : '' }}>Agua</option>
                <option value="Arriendo" {{ $gasto->tipo_gasto == 'Arriendo' ? 'selected' : '' }}>Arriendo</option>
                <option value="Otros" {{ $gasto->tipo_gasto == 'Otros' ? 'selected' : '' }}>Otros</option>
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ $gasto->fecha }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" id="monto" value="{{ $gasto->monto }}" step="0.01"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-bold mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="Pagado" {{ $gasto->estado == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="Pendiente" {{ $gasto->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">{{ $gasto->descripcion }}</textarea>
        </div>

        <!-- Botón de Guardar -->
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
