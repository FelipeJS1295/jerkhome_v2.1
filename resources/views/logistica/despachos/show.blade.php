@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalle del Despacho</h1>

    <div class="mb-6 bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Información del Despacho</h2>
        <p><strong>Tipo de Despacho:</strong> {{ $despacho->tipo }}</p>
        <p><strong>Transporte:</strong> {{ $despacho->transporte }}</p>
        <p><strong>Conductor:</strong> {{ $despacho->conductor }}</p>
        <p><strong>Monto:</strong> ${{ number_format($despacho->monto, 2) }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($despacho->estado) }}</p>
    </div>

    <div class="mb-6 bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Órdenes Asociadas</h2>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-left">Cliente</th>
                    <th class="py-3 px-4 text-left">Número de Orden</th>
                    <th class="py-3 px-4 text-left">Fecha</th>
                    <th class="py-3 px-4 text-left">Producto</th>
                    <th class="py-3 px-4 text-left">Estado</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($ordenes as $orden)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-4">{{ $orden->cliente_nombre }}</td>
                    <td class="py-3 px-4">{{ $orden->numero_orden }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ $orden->producto }}</td>
                    <td class="py-3 px-4">{{ ucfirst($orden->estado) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('logistica.despachos.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
        Volver a la Lista de Despachos
    </a>
</div>
@endsection
