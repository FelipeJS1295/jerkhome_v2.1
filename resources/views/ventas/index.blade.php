@extends('layouts.app')

@section('content')
<div class="sl-container">
    <!-- Header Section -->
    <div class="sl-header">
        <div class="sl-title-wrap">
            <h1 class="sl-title">Listado de Ventas</h1>
        </div>
        
        <div class="sl-header-actions">
            <a href="{{ route('ventas.import.view') }}" class="sl-btn sl-btn-primary">
                <i class="fas fa-file-import"></i>
                <span>Importar Órdenes</span>
            </a>
            <a href="{{ route('ventas.maestra') }}" class="sl-btn sl-btn-secondary" target="_blank">
                <i class="fas fa-table"></i>
                <span>Ver Maestra</span>
            </a>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="sl-alert sl-alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="sl-alert sl-alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filters Section -->
    <div class="sl-filters">
        <form action="{{ route('ventas.index') }}" method="GET" class="sl-filter-form">
            <div class="sl-filter-grid">
                <div class="sl-form-group">
                    <label class="sl-label">Cliente</label>
                    <div class="sl-input-icon-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="cliente" 
                               class="sl-input" 
                               value="{{ request('cliente') }}" 
                               placeholder="Nombre del cliente">
                    </div>
                </div>

                <div class="sl-form-group">
                    <label class="sl-label">Número de Orden</label>
                    <div class="sl-input-icon-wrapper">
                        <i class="fas fa-hashtag"></i>
                        <input type="text" name="numero_orden" 
                               class="sl-input" 
                               value="{{ request('numero_orden') }}" 
                               placeholder="Número de Orden">
                    </div>
                </div>

                <div class="sl-form-group">
                    <label class="sl-label">Estado</label>
                    <div class="sl-input-icon-wrapper">
                        <i class="fas fa-tag"></i>
                        <select name="estado" class="sl-select">
                            <option value="">Todos</option>
                            <option value="Nueva" {{ request('estado') == 'Nueva' ? 'selected' : '' }}>Nueva</option>
                            <option value="Despachada" {{ request('estado') == 'Despachada' ? 'selected' : '' }}>Despachada</option>
                        </select>
                    </div>
                </div>

                <div class="sl-form-group">
                    <label class="sl-label">Fecha Desde</label>
                    <div class="sl-input-icon-wrapper">
                        <i class="fas fa-calendar"></i>
                        <input type="date" name="fecha_entrega_desde" 
                               class="sl-input" 
                               value="{{ request('fecha_entrega_desde') }}">
                    </div>
                </div>

                <div class="sl-form-group">
                    <label class="sl-label">Fecha Hasta</label>
                    <div class="sl-input-icon-wrapper">
                        <i class="fas fa-calendar"></i>
                        <input type="date" name="fecha_entrega_hasta" 
                               class="sl-input" 
                               value="{{ request('fecha_entrega_hasta') }}">
                    </div>
                </div>

                <div class="sl-filter-actions">
                    <button type="submit" class="sl-btn sl-btn-primary">
                        <i class="fas fa-search"></i>
                        <span>Filtrar</span>
                    </button>
                    <a href="{{ route('ventas.index') }}" class="sl-btn sl-btn-secondary">
                        <i class="fas fa-undo"></i>
                        <span>Limpiar</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="sl-bulk-actions">
        <select id="bulk-status" class="sl-select">
            <option value="">Cambiar Estado</option>
            <option value="Nueva">Nueva</option>
            <option value="Despachada">Despachada</option>
        </select>
        <button id="change-status-btn" class="sl-btn sl-btn-secondary" disabled>
            <i class="fas fa-sync-alt"></i>
            <span>Actualizar Estado</span>
        </button>
    </div>

    <!-- Table Section -->
    <div class="sl-table-container">
        <table class="sl-table">
            <thead>
                <tr>
                    <th class="sl-th sl-th-checkbox">
                        <label class="sl-checkbox">
                            <input type="checkbox" id="select-all">
                            <span class="sl-checkmark"></span>
                        </label>
                    </th>
                    <th class="sl-th">
                        <a href="?sort_by=cliente&sort_direction={{ request('sort_direction') == 'asc' ? 'desc' : 'asc' }}" 
                           class="sl-sort-link">
                            Cliente
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th class="sl-th">
                        <a href="?sort_by=numero_orden&sort_direction={{ request('sort_direction') == 'asc' ? 'desc' : 'asc' }}" 
                           class="sl-sort-link">
                            N° Orden
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th class="sl-th">
                        <a href="?sort_by=fecha_entrega&sort_direction={{ request('sort_direction') == 'asc' ? 'desc' : 'asc' }}" 
                           class="sl-sort-link">
                            Fecha Entrega
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th class="sl-th">SKU</th>
                    <th class="sl-th">Nombre</th>
                    <th class="sl-th">Precio</th>
                    <th class="sl-th">
                        <a href="?sort_by=estado&sort_direction={{ request('sort_direction') == 'asc' ? 'desc' : 'asc' }}" 
                           class="sl-sort-link">
                            Estado
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th class="sl-th sl-th-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                <tr class="sl-tr">
                    <td class="sl-td">
                        <label class="sl-checkbox">
                            <input type="checkbox" class="select-order" value="{{ $venta->id }}">
                            <span class="sl-checkmark"></span>
                        </label>
                    </td>
                    <td class="sl-td">{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                    <td class="sl-td sl-order-number">{{ $venta->numero_orden }}</td>
                    <td class="sl-td">{{ Carbon\Carbon::parse($venta->fecha_entrega)->format('d-m-Y') }}</td>
                    <td class="sl-td sl-sku">{{ $venta->sku }}</td>
                    <td class="sl-td">{{ $venta->producto }}</td>
                    <td class="sl-td sl-price">${{ number_format($venta->precio, 0, ',', '.') }}</td>
                    <td class="sl-td">
                        <span class="sl-status {{ $venta->estado == 'Nueva' ? 'sl-status-new' : 'sl-status-dispatched' }}">
                            {{ $venta->estado }}
                        </span>
                    </td>
                    <td class="sl-td sl-actions">
                        <div class="sl-action-buttons">
                            <a href="{{ route('ventas.show', $venta->id) }}" 
                               class="sl-action-btn sl-btn-view" 
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('ventas.edit', $venta->id) }}" 
                               class="sl-action-btn sl-btn-edit" 
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" 
                                  method="POST" 
                                  class="sl-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="sl-action-btn sl-btn-delete" 
                                        onclick="confirmDelete(this)"
                                        title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="sl-td sl-empty">
                        <div class="sl-empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No se encontraron ventas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="sl-pagination">
        {{ $ventas->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.select-order');
    const selectAll = document.getElementById('select-all');
    const changeStatusBtn = document.getElementById('change-status-btn');
    const bulkStatus = document.getElementById('bulk-status');

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        toggleButton();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleButton);
    });

    function toggleButton() {
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        changeStatusBtn.disabled = !anyChecked || !bulkStatus.value;
        changeStatusBtn.classList.toggle('sl-btn-active', anyChecked && bulkStatus.value);
    }

    bulkStatus.addEventListener('change', toggleButton);

    changeStatusBtn.addEventListener('click', function () {
        if (changeStatusBtn.disabled) return;

        const selectedOrders = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        fetch("{{ route('ventas.updateStatusBulk') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ids: selectedOrders,
                estado: bulkStatus.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Hubo un error al actualizar los estados.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error en la actualización.');
        });
    });
});

function confirmDelete(button) {
    if (confirm('¿Estás seguro de eliminar esta venta?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection