@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Mensajes de éxito o error -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <header class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Registrar Reparación</h1>
    </header>

    <form action="{{ route('produccion.storeReparacion') }}" method="POST">
        @csrf
        <!-- Selección de trabajador -->
        <div class="mb-4">
            <label for="trabajadores_id" class="block text-sm font-medium text-gray-700">Trabajador Asignado</label>
            <select name="trabajadores_id" id="trabajadores_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">Seleccione un trabajador</option>
                @foreach ($trabajadores as $trabajador)
                    <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tabla para agregar reparaciones -->
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full border border-gray-300 rounded-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Producto</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">N° Orden</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Descripción</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Precio Reparación</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody id="reparaciones-container">
                    <tr>
                        <td class="px-4 py-2 border-b">
                            <select name="ordenes[0][producto_id]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Seleccione un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2 border-b">
                            <input type="date" name="ordenes[0][fecha]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </td>
                        <td class="px-4 py-2 border-b">
                            <input type="text" name="ordenes[0][numero_orden_trabajo]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </td>
                        <td class="px-4 py-2 border-b">
                            <input type="text" name="ordenes[0][descripcion]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </td>
                        <td class="px-4 py-2 border-b">
                            <input type="number" name="ordenes[0][precio_reparacion]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" step="0.01">
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeRow(this)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Botones -->
        <div class="flex justify-end">
            <button type="button" id="add-reparacion-row" class="bg-green-500 text-white px-4 py-2 rounded-md mr-2">Agregar Reparación</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Reparaciones</button>
        </div>
    </form>
</div>

<script>
    let reparacionIndex = 1;

    document.getElementById('add-reparacion-row').addEventListener('click', function () {
        const container = document.getElementById('reparaciones-container');
        const newRow = `
            <tr>
                <td class="px-4 py-2 border-b">
                    <select name="ordenes[${reparacionIndex}][producto_id]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-2 border-b">
                    <input type="date" name="ordenes[${reparacionIndex}][fecha]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </td>
                <td class="px-4 py-2 border-b">
                    <input type="text" name="ordenes[${reparacionIndex}][numero_orden_trabajo]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </td>
                <td class="px-4 py-2 border-b">
                    <input type="text" name="ordenes[${reparacionIndex}][descripcion]" class="w-full border border-gray-300 rounded-md shadow-sm py -2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </td>
                <td class="px-4 py-2 border-b">
                    <input type="number" name="ordenes[${reparacionIndex}][precio_reparacion]" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" step="0.01">
                </td>
                <td class="px-4 py-2 border-b text-center">
                    <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeRow(this)">Eliminar</button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', newRow);
        reparacionIndex++;
    });

    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>
@endsection
