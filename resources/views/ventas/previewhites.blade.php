@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Previsualización de Ventas - Hites</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Número de Orden</th>
                <th>Fecha Compra</th>
                <th>Precio</th>
                <th>Precio Cliente</th>
                <th>Costo Despacho</th>
                <th>Cliente Final</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr class="{{ $venta['ya_existe'] ? 'bg-danger text-white' : '' }}">
                <td>{{ $venta['numero_orden'] ?? 'N/A' }}</td>
                <td>{{ $venta['fecha_compra'] ?? 'N/A' }}</td>
                <td>${{ number_format($venta['precio'] ?? 0, 0, ',', '.') }}</td>
                <td>${{ number_format($venta['precio_cliente'] ?? 0, 0, ',', '.') }}</td>
                <td>${{ number_format($venta['costo_despacho'] ?? 0, 0, ',', '.') }}</td>
                <td>{{ $venta['cliente_final'] ?? 'N/A' }}</td>
                <td>{{ $venta['telefono'] ?? 'N/A' }}</td>
                <td>{{ $venta['email'] ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
    <form action="{{ route('ventas.guardarPreviewHites') }}" method="POST">
        @csrf
        <input type="hidden" name="ventas" value="{{ json_encode($ventas) }}">
        <button type="submit" class="btn btn-success">Guardar Ventas</button>
    </form>
    </div>
</div>
@endsection
