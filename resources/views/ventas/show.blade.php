@extends('layouts.app')

@section('content')
<div class="od-container">
    <div class="od-header">
        <div class="od-title-section">
            <h1 class="od-title">Detalles de la Orden</h1>
            <span class="od-order-number"># {{ $venta->numero_orden }}</span>
        </div>
        
        <span class="od-status-badge {{ $venta->estado == 'Nueva' ? 'od-status-new' : 'od-status-dispatched' }}">
            {{ $venta->estado }}
        </span>
    </div>

    @if(session('error'))
        <div class="od-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="od-content">
        <!-- Información del Cliente -->
        <div class="od-card">
            <div class="od-card-header">
                <i class="fas fa-user"></i>
                <h2>Información del Cliente</h2>
            </div>
            <div class="od-card-body">
                <div class="od-info-grid">
                    <div class="od-info-item">
                        <span class="od-label">Cliente Final</span>
                        <span class="od-value">{{ $venta->cliente_final }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">RUT</span>
                        <span class="od-value">{{ $venta->rut }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Razón Social</span>
                        <span class="od-value">{{ $venta->razon_social }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Email</span>
                        <span class="od-value">{{ $venta->email }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Teléfono</span>
                        <span class="od-value">{{ $venta->telefono }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Producto -->
        <div class="od-card">
            <div class="od-card-header">
                <i class="fas fa-box"></i>
                <h2>Detalles del Producto</h2>
            </div>
            <div class="od-card-body">
                <div class="od-info-grid">
                    <div class="od-info-item">
                        <span class="od-label">Producto</span>
                        <span class="od-value">{{ $venta->producto }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">SKU</span>
                        <span class="od-value od-sku">{{ $venta->sku }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Precio</span>
                        <span class="od-value od-price">${{ number_format($venta->precio, 0, ',', '.') }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Precio Cliente</span>
                        <span class="od-value od-price">${{ number_format($venta->precio_cliente, 0, ',', '.') }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Costo Despacho</span>
                        <span class="od-value">${{ number_format($venta->costo_despacho, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Entrega -->
        <div class="od-card">
            <div class="od-card-header">
                <i class="fas fa-truck"></i>
                <h2>Información de Entrega</h2>
            </div>
            <div class="od-card-body">
                <div class="od-info-grid">
                    <div class="od-info-item">
                        <span class="od-label">Dirección</span>
                        <span class="od-value">{{ $venta->direccion }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Comuna</span>
                        <span class="od-value">{{ $venta->comuna }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Región</span>
                        <span class="od-value">{{ $venta->region }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Courier</span>
                        <span class="od-value">{{ $venta->currier }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fechas -->
        <div class="od-card">
            <div class="od-card-header">
                <i class="fas fa-calendar"></i>
                <h2>Fechas</h2>
            </div>
            <div class="od-card-body">
                <div class="od-info-grid">
                    <div class="od-info-item">
                        <span class="od-label">Fecha de Compra</span>
                        <span class="od-value">{{ \Carbon\Carbon::parse($venta->fecha_compra)->format('d-m-Y') }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Fecha de Entrega</span>
                        <span class="od-value">{{ \Carbon\Carbon::parse($venta->fecha_entrega)->format('d-m-Y') }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Fecha Cliente</span>
                        <span class="od-value">{{ \Carbon\Carbon::parse($venta->fecha_cliente)->format('d-m-Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="od-card">
            <div class="od-card-header">
                <i class="fas fa-info-circle"></i>
                <h2>Información Adicional</h2>
            </div>
            <div class="od-card-body">
                <div class="od-info-grid">
                    <div class="od-info-item">
                        <span class="od-label">Documento</span>
                        <span class="od-value">{{ $venta->documento }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">RUT Documento</span>
                        <span class="od-value">{{ $venta->rut_documento }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Giro</span>
                        <span class="od-value">{{ $venta->giro }}</span>
                    </div>
                    <div class="od-info-item">
                        <span class="od-label">Dirección Factura</span>
                        <span class="od-value">{{ $venta->direccion_factura }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="od-actions">
        <div class="od-action-buttons">
            <a href="{{ route('ventas.edit', $venta->id) }}" class="od-btn od-btn-edit">
                <i class="fas fa-edit"></i>
                <span>Editar Orden</span>
            </a>
            
            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" class="od-delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="od-btn od-btn-delete" onclick="confirmDelete(this)">
                    <i class="fas fa-trash-alt"></i>
                    <span>Eliminar Orden</span>
                </button>
            </form>
        </div>
        
        <a href="{{ route('ventas.index') }}" class="od-btn od-btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Volver al Listado</span>
        </a>
    </div>
</div>

<script>
function confirmDelete(button) {
    if (confirm('¿Está seguro de eliminar esta orden?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection