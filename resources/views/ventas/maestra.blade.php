<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestra de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        th, td {
            border: 1px solid black;
            padding: 5px; /* Reducir padding para ahorrar espacio */
            text-align: left;
            font-size: 10px; /* Reducir tamaño de fuente */
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            font-size: 14px; /* Reducir tamaño del título */
            text-align: center;
            margin: 10px 0;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .bg-blue-50 {
            background-color: #ebf8ff;
        }

        .bg-gray-100 {
            background-color: #f3f4f6;
        }

        .bg-gray-800 {
            background-color: #2d3748;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Estilos de impresión */
        @media print {
            @page {
                size: A4; /* Tamaño de página A4 */
                margin: 0.5cm; /* Márgenes más pequeños */
            }

            body {
                font-size: 10px; /* Reducir tamaño de fuente global */
            }

            table {
                font-size: 9px; /* Reducir aún más el tamaño de la tabla */
            }

            th, td {
                padding: 2px; /* Reducir padding en celdas */
            }

            h1 {
                font-size: 12px; /* Ajustar tamaño del título */
                margin: 5px 0;
            }

            .no-print {
                display: none; /* Ocultar elementos no necesarios durante la impresión */
            }
        }
    </style>
</head>
<body>
    <header class="no-print" style="margin: 10px; display: flex; justify-content: space-between; align-items: center;">
        <h1 class="font-bold">Maestra de Ventas</h1>
        <button onclick="window.print()" style="padding: 5px 10px; background-color: #4A90E2; color: white; border: none; border-radius: 3px; cursor: pointer;">
            Imprimir
        </button>
    </header>

    <h1>Maestra de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                @foreach ($fechas as $fecha)
                    <th class="text-center">{{ \Carbon\Carbon::parse($fecha)->format('d-m-Y') }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr class="bg-blue-50">
                <td colspan="{{ count($fechas) + 2 }}" class="font-bold">
                    {{ strtoupper($cliente->nombre) }}
                </td>
            </tr>
            @foreach ($cliente->productos as $producto)
            <tr>
                <td>{{ $producto['producto'] }}</td>
                @foreach ($producto['fechas'] as $cantidad)
                    <td class="text-center">{{ $cantidad > 0 ? number_format($cantidad, 0) : '-' }}</td>
                @endforeach
                <td class="text-center font-bold">{{ number_format($producto['total'], 0) }}</td>
            </tr>
            @endforeach
            <tr class="bg-gray-100">
                <td class="font-bold">Total {{ strtoupper($cliente->nombre) }}</td>
                <td colspan="{{ count($fechas) }}"></td>
                <td class="text-center font-bold">{{ number_format($totalesPorCliente[$cliente->id] ?? 0, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-800 text-white">
                <td class="font-bold">TOTAL GENERAL</td>
                @foreach ($fechas as $fecha)
                    <td class="text-center font-bold">{{ number_format($totalesPorFecha[$fecha] ?? 0, 0) }}</td>
                @endforeach
                <td class="text-center font-bold">{{ number_format($granTotal, 0) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

