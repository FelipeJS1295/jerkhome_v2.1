@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Despacho</h1>

    <form action="{{ route('logistica.despachos.update', $despacho->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        @csrf
        @method('PUT')

        <!-- Tipo de Despacho -->
        <div class="mb-4">
            <label for="tipo" class="block text-gray-700 font-bold mb-2">Tipo de Despacho</label>
            <select name="tipo" id="tipo" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="retail" {{ $despacho->tipo == 'retail' ? 'selected' : '' }}>Retail</option>
                <option value="clientes" {{ $despacho->tipo == 'clientes' ? 'selected' : '' }}>Clientes</option>
                <option value="otros" {{ $despacho->tipo == 'otros' ? 'selected' : '' }}>Otros</option>
            </select>
        </div>

        <!-- Transporte -->
        <div class="mb-4">
            <label for="transporte" class="block text-gray-700 font-bold mb-2">Transporte</label>
            <input type="text" name="transporte" id="transporte" value="{{ $despacho->transporte }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Conductor -->
        <div class="mb-4">
            <label for="conductor" class="block text-gray-700 font-bold mb-2">Conductor</label>
            <input type="text" name="conductor" id="conductor" value="{{ $despacho->conductor }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" step="0.01" name="monto" id="monto" value="{{ $despacho->monto }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-bold mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="pendiente" {{ $despacho->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="pagado" {{ $despacho->estado == 'pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>

        <!-- Órdenes Asociadas -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Órdenes Asociadas</label>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">Cliente</th>
                        <th class="py-3 px-4 text-left">Número de Orden</th>
                        <th class="py-3 px-4 text-left">Producto</th>
                        <th class="py-3 px-4 text-center">Seleccionar</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($ordenesDisponibles as $orden)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $orden->cliente_nombre }}</td>
                        <td class="py-3 px-4">{{ $orden->numero_orden }}</td>
                        <td class="py-3 px-4">{{ $orden->producto }}</td>
                        <td class="py-3 px-4 text-center">
                            <input type="checkbox" name="ordenes[]" value="{{ $orden->id }}"
                                   {{ in_array($orden->id, $ordenesSeleccionadas->pluck('id')->toArray()) ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botón Guardar -->
        <div class="text-center">
            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection