@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Planilla de Sueldos - {{ \Carbon\Carbon::now()->format('F Y') }}</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sueldo Base</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Horas Extras</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Faltas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Vacaciones</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Bonos</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quincenas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Préstamos</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    // Variables para totales por columna
                    $totalSueldoBase = 0;
                    $totalHorasExtras = 0;
                    $totalFaltas = 0;
                    $totalVacaciones = 0;
                    $totalBonos = 0;
                    $totalQuincenas = 0;
                    $totalPrestamos = 0;
                    $totalGeneral = 0;
                @endphp
                @foreach($planilla as $item)
                @php
                // Acumular totales por columna
                $totalSueldoBase += $item['sueldo_base'];
                $totalHorasExtras += $item['horas_extras'];
                $totalFaltas += $item['faltas'];
                $totalVacaciones += $item['vacaciones'];
                $totalBonos += $item['bonos'];
                $totalQuincenas += $item['quincenas'];
                $totalPrestamos += $item['prestamos'];
                $totalGeneral += $item['total'];
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['trabajador'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item['rut'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${{ number_format($item['sueldo_base'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right">${{ number_format($item['horas_extras'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 text-right">-${{ number_format($item['faltas'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 text-right">-${{ number_format($item['vacaciones'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right">${{ number_format($item['bonos'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 text-right">-${{ number_format($item['quincenas'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 text-right">-${{ number_format($item['prestamos'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">${{ number_format($item['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <th colspan="2" class="px-6 py-3 text-left text-sm font-medium text-gray-900">Totales</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-900">${{ number_format($totalSueldoBase, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-green-600">${{ number_format($totalHorasExtras, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-red-600">-${{ number_format($totalFaltas, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-red-600">-${{ number_format($totalVacaciones, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-green-600">${{ number_format($totalBonos, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-red-600">-${{ number_format($totalQuincenas, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-red-600">-${{ number_format($totalPrestamos, 2) }}</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-900">${{ number_format($totalGeneral, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection