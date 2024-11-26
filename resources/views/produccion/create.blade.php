@extends('layouts.app')

@section('content')
<div class="wo-container">
    <header class="wo-header">
        <h1 class="wo-title">Crear Órdenes de Trabajo</h1>
    </header>

    <div class="wo-form-wrapper">
        <!-- Selección de trabajador -->
        <div class="wo-worker-select">
            <label for="trabajador_id" class="wo-label">Trabajador Asignado</label>
            <select name="trabajador_id" id="trabajador_id" class="wo-select" required>
                <option value="">Seleccione un trabajador</option>
                @foreach ($trabajadores as $trabajador)
                    <option value="{{ $trabajador->id }}">
                        {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>

        <form action="{{ route('produccion.store') }}" method="POST" class="wo-form">
            @csrf
            <input type="hidden" name="trabajador_id" id="selected_trabajador_id">

            <div class="wo-table-wrapper">
                <table class="wo-table">
                    <thead class="wo-thead">
                        <tr>
                            <th class="wo-th">Producto</th>
                            <th class="wo-th">Fecha</th>
                            <th class="wo-th">N° Orden de Trabajo</th>
                            <th class="wo-th wo-th-actions">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="ordenes-container" class="wo-tbody">
                        <tr class="wo-row">
                            <td class="wo-cell">
                                <select name="ordenes[0][producto_id]" class="wo-product-select">
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="wo-cell">
                                <input type="date" name="ordenes[0][fecha]" class="wo-input-date" required>
                            </td>
                            <td class="wo-cell">
                                <input type="text" name="ordenes[0][numero_orden_trabajo]" 
                                       class="wo-input-text" placeholder="Número de orden" required>
                            </td>
                            <td class="wo-cell wo-cell-actions">
                                <button type="button" class="wo-btn-remove" title="Eliminar orden">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="wo-actions">
                <button type="button" id="add-order-row" class="wo-btn-add">
                    <i class="fas fa-plus"></i> Agregar Orden
                </button>
                <button type="submit" class="wo-btn-save">
                    <i class="fas fa-save"></i> Guardar Órdenes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trabajadorSelect = document.getElementById('trabajador_id');
    const selectedTrabajadorInput = document.getElementById('selected_trabajador_id');
    const ordenesContainer = document.getElementById('ordenes-container');
    const addOrderRowButton = document.getElementById('add-order-row');

    trabajadorSelect.addEventListener('change', function () {
        selectedTrabajadorInput.value = this.value;
    });

    let orderIndex = 1;

    addOrderRowButton.addEventListener('click', function () {
        const newRow = document.createElement('tr');
        newRow.className = 'wo-row wo-row-new';
        newRow.innerHTML = `
            <td class="wo-cell">
                <select name="ordenes[${orderIndex}][producto_id]" class="wo-product-select">
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </td>
            <td class="wo-cell">
                <input type="date" name="ordenes[${orderIndex}][fecha]" class="wo-input-date" required>
            </td>
            <td class="wo-cell">
                <input type="text" name="ordenes[${orderIndex}][numero_orden_trabajo]" 
                       class="wo-input-text" placeholder="Número de orden" required>
            </td>
            <td class="wo-cell wo-cell-actions">
                <button type="button" class="wo-btn-remove" title="Eliminar orden">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
        ordenesContainer.appendChild(newRow);
        orderIndex++;
    });

    ordenesContainer.addEventListener('click', function (e) {
        if (e.target.closest('.wo-btn-remove')) {
            const row = e.target.closest('.wo-row');
            row.classList.add('wo-row-remove');
            setTimeout(() => row.remove(), 300);
        }
    });
});
</script>
@endsection