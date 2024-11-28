@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalles del Crédito</h1>

    <!-- Información del Crédito -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Información del Crédito</h2>
        <p class="text-gray-700"><strong>Banco:</strong> {{ $credito->banco }}</p>
        <p class="text-gray-700"><strong>Monto:</strong> ${{ number_format($credito->monto, 2) }}</p>
        <p class="text-gray-700"><strong>Cuotas:</strong> {{ $credito->cuotas }}</p>
        <p class="text-gray-700"><strong>Tasa de Interés:</strong> {{ number_format($credito->tasa_interes, 2) }}%</p>
        <p class="text-gray-700"><strong>Monto Total:</strong> ${{ number_format($credito->monto_total, 2) }}</p>
        <p class="text-gray-700"><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($credito->fecha_inicio)->format('d/m/Y') }}</p>
    </div>

    <!-- Cuotas del Crédito -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Cuotas</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2 border border-gray-300 text-left">#</th>
                        <th class="px-4 py-2 border border-gray-300 text-right">Monto de la Cuota</th>
                        <th class="px-4 py-2 border border-gray-300 text-right">Interés</th>
                        <th class="px-4 py-2 border border-gray-300 text-right">Capital</th>
                        <th class="px-4 py-2 border border-gray-300 text-right">Fecha de Pago</th>
                        <th class="px-4 py-2 border border-gray-300 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuotas as $index => $cuota)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($cuota->monto_cuota, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($cuota->interes, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-right">${{ number_format($cuota->capital, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-right">{{ \Carbon\Carbon::parse($cuota->fecha_pago)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            @if($cuota->pagado)
                            <span class="text-green-500 font-bold">Pagado</span>
                            @else
                            <span class="text-red-500 font-bold">Pendiente</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botón de Regresar -->
    <div class="mt-6">
        <a href="{{ route('finanzas.creditos.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600">
            Volver a Créditos
        </a>
    </div>
</div>
@endsection
