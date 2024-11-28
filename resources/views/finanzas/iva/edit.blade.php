@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Registro de I.V.A.</h1>

    <form action="{{ route('finanzas.iva.update', $iva->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" id="monto" value="{{ $iva->monto }}" step="0.01"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ $iva->fecha }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-bold mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="Pagado" {{ $iva->estado == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="Pendiente" {{ $iva->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">{{ $iva->descripcion }}</textarea>
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
