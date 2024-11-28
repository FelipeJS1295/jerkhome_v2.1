@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto space-y-8">
        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-bold text-gray-900">
                Registrar Pagos
                <span class="text-gray-500 text-2xl ml-2">#{{ $factura->numero_documento }}</span>
            </h1>
        </div>

        {{-- Invoice Info --}}
        <div class="bg-white rounded-lg shadow-sm">
            <div class="grid md:grid-cols-3 gap-6 p-6">
                <div>
                    <p class="text-sm text-gray-500">Proveedor</p>
                    <p class="text-lg font-medium">{{ $factura->proveedor }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Monto Total</p>
                    <p class="text-lg font-medium">${{ number_format($factura->monto_total, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Estado</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($factura->estado === 'pagada') 
                            bg-green-100 text-green-800
                        @else 
                            bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($factura->estado) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Payment Form --}}
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-6">Nuevo Pago</h2>
                <form action="{{ route('finanzas.facturas.registrarPago', $factura->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Tipo de Pago</label>
                            <select name="tipo_pago" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione un tipo</option>
                                <option value="cheque">Cheque</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="cuota">Cuota</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Monto</label>
                            <input type="number" name="monto" step="0.01" placeholder="0.00" 
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Fecha del Pago</label>
                            <input type="date" name="fecha_pago"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium">Detalles</label>
                            <textarea name="detalles" rows="3" placeholder="Detalles adicionales del pago..."
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Registrar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Payments Table --}}
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-6">Pagos Registrados</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Tipo</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Monto</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Fecha</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Detalles</th>
                                <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pagos as $pago)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ ucfirst($pago->tipo_pago) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($pago->monto, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->detalles ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('finanzas.facturas.pagos.editar', $pago->id) }}" 
                                        class="text-blue-600 hover:text-blue-900">Editar</a>
                                    <form action="{{ route('finanzas.facturas.pagos.eliminar', $pago->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('¿Está seguro de eliminar este pago?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection