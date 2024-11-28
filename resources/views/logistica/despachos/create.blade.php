@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Crear Despacho</h1>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('logistica.despachos.store') }}" method="POST" class="bg-white shadow-xl rounded-xl p-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Tipo de Despacho -->
                <div>
                    <label for="tipo_despacho" class="text-sm font-medium text-gray-700">Tipo de Despacho</label>
                    <select name="tipo_despacho" id="tipo_despacho" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="retail">Retail</option>
                        <option value="clientes">Clientes</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <!-- Transporte -->
                <div>
                    <label for="transporte" class="text-sm font-medium text-gray-700">Transporte</label>
                    <input type="text" name="transporte" id="transporte" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Conductor -->
                <div>
                    <label for="conductor" class="text-sm font-medium text-gray-700">Conductor</label>
                    <input type="text" name="conductor" id="conductor" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Monto -->
                <div>
                    <label for="monto" class="text-sm font-medium text-gray-700">Monto del Despacho</label>
                    <input type="number" step="0.01" name="monto" id="monto" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="text-sm font-medium text-gray-700">Estado</label>
                    <select name="estado" id="estado" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                    </select>
                </div>

                <!-- Órdenes -->
                <div class="flex items-end">
                    <button type="button" onclick="abrirModal()" class="w-full h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Seleccionar Órdenes
                    </button>
                </div>
            </div>

            <!-- Tabla de Órdenes Seleccionadas -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Órdenes Seleccionadas</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-lg" id="tablaOrdenesSeleccionadas">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="ordenesSeleccionadasBody">
                            <tr id="noOrdenesRow">
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay órdenes seleccionadas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                    Crear Despacho
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Selección -->
<div id="modalOrdenes" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-11/12 max-w-4xl">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">Seleccionar Órdenes</h2>
            <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Filtros -->
        <div class="px-6 py-3 bg-gray-50 border-b">
            <input 
                type="text" 
                id="clienteFilter" 
                placeholder="Filtrar por cliente..." 
                class="w-full md:w-64 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                onkeyup="filtrarOrdenes()"
            >
        </div>

        <div style="max-height: 60vh;" class="overflow-y-auto">
            <table class="w-full" id="tablaOrdenes">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="text-left p-4">Cliente</th>
                        <th class="text-left p-4">Orden</th>
                        <th class="text-left p-4">Fecha</th>
                        <th class="text-left p-4">Producto</th>
                        <th class="text-center p-4">Select</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $venta->cliente_nombre }}</td>
                            <td class="p-4">{{ $venta->numero_orden }}</td>
                            <td class="p-4">{{ $venta->fecha }}</td>
                            <td class="p-4">{{ $venta->producto }}</td>
                            <td class="p-4 text-center">
                                <input type="checkbox" name="ordenes[]" value="{{ $venta->id }}">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No hay ventas disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t flex justify-end gap-2">
            <button onclick="cerrarModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Cancelar
            </button>
            <button onclick="confirmarSeleccion()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById('modalOrdenes').classList.remove('hidden');
    document.getElementById('modalOrdenes').classList.add('flex');
}

function cerrarModal() {
    document.getElementById('modalOrdenes').classList.remove('flex');
    document.getElementById('modalOrdenes').classList.add('hidden');
}

function filtrarOrdenes() {
    const input = document.getElementById('clienteFilter');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('tablaOrdenes');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const clienteCell = rows[i].getElementsByTagName('td')[0];
        if (clienteCell) {
            const clienteText = clienteCell.textContent || clienteCell.innerText;
            rows[i].style.display = clienteText.toLowerCase().includes(filter) ? '' : 'none';
        }
    }
}

function confirmarSeleccion() {
    const checkboxes = document.querySelectorAll('input[name="ordenes[]"]:checked');
    const tbody = document.getElementById('ordenesSeleccionadasBody');
    const noOrdenesRow = document.getElementById('noOrdenesRow');
    
    if (checkboxes.length > 0 && noOrdenesRow) {
        noOrdenesRow.remove();
    }

    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        const cliente = row.cells[0].textContent;
        const orden = row.cells[1].textContent;
        const fecha = row.cells[2].textContent;
        const producto = row.cells[3].textContent;

        // Verificar si la orden ya está en la tabla
        if (!document.querySelector(`#orden-${checkbox.value}`)) {
            const newRow = document.createElement('tr');
            newRow.id = `orden-${checkbox.value}`;
            newRow.innerHTML = `
                <td class="px-4 py-2">${cliente}</td>
                <td class="px-4 py-2">${orden}</td>
                <td class="px-4 py-2">${fecha}</td>
                <td class="px-4 py-2">${producto}</td>
                <td class="px-4 py-2 text-center">
                    <button onclick="removeOrden('${checkbox.value}')" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
        }
    });

    cerrarModal();
}

function removeOrden(ordenId) {
    const row = document.getElementById(`orden-${ordenId}`);
    if (row) {
        row.remove();
        
        // Desmarcar el checkbox en el modal
        const checkbox = document.querySelector(`input[name="ordenes[]"][value="${ordenId}"]`);
        if (checkbox) checkbox.checked = false;

        // Si no hay más órdenes, mostrar el mensaje
        const tbody = document.getElementById('ordenesSeleccionadasBody');
        if (tbody.children.length === 0) {
            tbody.innerHTML = `
                <tr id="noOrdenesRow">
                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay órdenes seleccionadas</td>
                </tr>
            `;
        }
    }
}
</script>
@endsection