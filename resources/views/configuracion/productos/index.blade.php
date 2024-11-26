@extends('layouts.app')

@section('content')
<div class="product-dashboard">
    <div class="dashboard-header">
        <h1>Productos</h1>
        <a href="{{ route('productos.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> Crear Producto
        </a>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Esqueleto</th>
                    <th class="actions-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td class="sku-cell">{{ $producto->sku }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->esqueleto }}</td>
                    <td class="actions-cell">
                        <div class="action-buttons">
                            <a href="{{ route('productos.show', $producto->id) }}" class="btn-view" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn-edit" title="Editar producto">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('productos.copy', $producto->id) }}" class="btn-copy" title="Copiar producto">
                                <i class="fas fa-copy"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete" title="Eliminar producto" onclick="confirmDelete(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(button) {
    if (confirm('¿Seguro que deseas eliminar este producto?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection
