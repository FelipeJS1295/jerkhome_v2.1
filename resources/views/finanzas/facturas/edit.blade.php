@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Factura de Compra</h1>

    <form action="{{ route('finanzas.facturas.update', $factura->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        @csrf
        @method('PUT')

        <!-- Proveedor -->
        <div class="mb-4">
            <label for="proveedor_id" class="block text-gray-700 font-bold mb-2">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ $factura->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ $factura->fecha }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Número de Documento -->
        <div class="mb-4">
            <label for="numero_documento" class="block text-gray-700 font-bold mb-2">Número de Documento</label>
            <input type="text" name="numero_documento" id="numero_documento" value="{{ $factura->numero_documento }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Insumos -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Insumos</label>
            <table class="w-full border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">SKU</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insumosFactura as $insumo)
                    <tr>
                        <td>
                            {{ $insumo->sku_hijo }}
                        </td>
                        <td>
                            {{ $insumo->nombre }}
                        </td>
                        <td>
                            <input type="number" name="insumos[{{ $insumo->id }}][cantidad]" value="{{ $insumo->cantidad }}"
                                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
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
