@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Factura de Compra</h1>

    <!-- Mostrar mensajes de error -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 border border-red-400 rounded-lg p-4">
            <h2 class="font-bold text-lg">Se encontraron errores:</h2>
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('finanzas.facturas.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        @csrf

        <!-- Proveedor -->
        <div class="mb-4">
            <label for="proveedor_id" class="block text-gray-700 font-bold mb-2">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Número de Documento -->
        <div class="mb-4">
            <label for="numero_documento" class="block text-gray-700 font-bold mb-2">Número de Documento</label>
            <input type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento') }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Insumos -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Insumos</label>
            <table class="w-full border border-gray-300 rounded-lg" id="insumosTable">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">SKU</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Cantidad</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="insumos[0][id]" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 insumo-select" onchange="updateInsumoName(this)" required>
                                <option value="">Seleccione un insumo</option>
                                @foreach($insumos as $insumo)
                                    <option value="{{ $insumo->id }}" data-nombre="{{ $insumo->nombre }}">
                                        {{ $insumo->sku_hijo }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="insumo-nombre">
                            <input type="text" class="w-full border border-gray-300 rounded-lg p-2" readonly>
                        </td>
                        <td>
                            <input type="number" name="insumos[0][cantidad]" value="{{ old('insumos.0.cantidad') }}"
                                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="bg-red-500 text-white font-bold py-1 px-2 rounded-lg hover:bg-red-600 remove-row">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="addRow" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
                Agregar Insumo
            </button>
        </div>

        <!-- Botón Enviar -->
        <div class="text-center">
            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600">
                Registrar Factura
            </button>
        </div>
    </form>
</div>

<script>
    let rowCount = 1;

    function updateInsumoName(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const nombre = selectedOption.getAttribute('data-nombre');
        const nombreInput = selectElement.closest('tr').querySelector('.insumo-nombre input');
        nombreInput.value = nombre || '';
    }

    document.getElementById('addRow').addEventListener('click', function () {
        const table = document.getElementById('insumosTable').querySelector('tbody');
        const newRow = `
        <tr>
            <td>
                <select name="insumos[${rowCount}][id]" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 insumo-select" onchange="updateInsumoName(this)" required>
                    <option value="">Seleccione un insumo</option>
                    @foreach($insumos as $insumo)
                        <option value="{{ $insumo->id }}" data-nombre="{{ $insumo->nombre }}">{{ $insumo->sku_hijo }}</option>
                    @endforeach
                </select>
            </td>
            <td class="insumo-nombre">
                <input type="text" class="w-full border border-gray-300 rounded-lg p-2" readonly>
            </td>
            <td>
                <input type="number" name="insumos[${rowCount}][cantidad]" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
            </td>
            <td class="text-center">
                <button type="button" class="bg-red-500 text-white font-bold py-1 px-2 rounded-lg hover:bg-red-600 remove-row">
                    Eliminar
                </button>
            </td>
        </tr>`;
        table.insertAdjacentHTML('beforeend', newRow);
        rowCount++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection