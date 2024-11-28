@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalles de la Factura de Compra</h1>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <!-- Proveedor -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Proveedor</h2>
            <p class="text-gray-700">{{ $factura->proveedor }}</p>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Fecha</h2>
            <p class="text-gray-700">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</p>
        </div>

        <!-- Número de Documento -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Número de Documento</h2>
            <p class="text-gray-700">{{ $factura->numero_documento }}</p>
        </div>

        <!-- Insumos -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-700">Insumos</h2>
            <ul class="list-disc pl-6 text-gray-700">
                @foreach($insumosFactura as $insumo)
                <li>{{ $insumo->sku_hijo }} - {{ $insumo->nombre }} (Cantidad: {{ $insumo->cantidad }})</li>
                @endforeach
            </ul>
        </div>

        <!-- Botón Volver -->
        <div class="text-center">
            <a href="{{ route('finanzas.facturas.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600">
                Volver a la Lista
            </a>
        </div>
    </div>
</div>
@endsection
