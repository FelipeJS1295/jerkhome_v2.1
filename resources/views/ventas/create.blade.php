@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Crear Venta</h1>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <!-- Cliente -->
        <div class="form-group">
            <label for="cliente">Cliente</label>
            <input type="text" name="cliente" id="cliente" class="form-control" required>
        </div>

        <!-- Fecha Entrega -->
        <div class="form-group">
            <label for="fecha_entrega">Fecha Entrega</label>
            <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" required>
        </div>

        <!-- N° Orden -->
        <div class="form-group">
            <label for="numero_orden">N° Orden</label>
            <input type="text" name="numero_orden" id="numero_orden" class="form-control" required>
        </div>

        <!-- SKU -->
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" required>
        </div>

        <!-- Nombre -->
        <div class="form-group">
            <label for="producto">Nombre</label>
            <input type="text" name="producto" id="producto" class="form-control" required>
        </div>

        <!-- Precio Pago Cliente -->
        <div class="form-group">
            <label for="precio_cliente">Precio Pago Cliente</label>
            <input type="number" step="0.01" name="precio_cliente" id="precio_cliente" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Venta</button>
    </form>
</div>
@endsection
