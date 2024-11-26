@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Previsualización de Actualización de Órdenes</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Número de Orden</th>
                <th>SKU</th>
                <th>Producto</th>
                <th>Precio Cliente</th>
                <th>RUT Documento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
            <tr>
                <td>{{ $orden['numero_orden'] }}</td>
                <td>{{ $orden['sku'] }}</td>
                <td>{{ $orden['producto'] }}</td>
                <td>${{ number_format($orden['precio_cliente'], 0, ',', '.') }}</td>
                <td>{{ $orden['rut_documento'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('ventas.guardarActualizarHites') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="ordenes" value="{{ json_encode($ordenes) }}">
        <button type="submit" class="btn btn-success">Guardar Actualizaciones</button>
    </form>
</div>
@endsection
