<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Producción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background: white;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .totals-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .totals-row td {
            border-top: 2px solid #bbb;
            color: #2c3e50;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            float: right;
            margin-top: 20px;
        }

        button:hover {
            background-color: #2980b9;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
                background: white;
            }

            .container {
                box-shadow: none;
                padding: 0;
                margin: 0;
                width: auto;
            }

            button {
                display: none;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #aaa;
                font-size: 10px;
            }

            .totals-row td {
                border-top: 2px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informe de Producción</h1>
        <table>
            <thead>
                <tr>
                    <th>Trabajador</th>
                    <th>Producto</th>
                    <th>Fecha</th>
                    <th>N° Orden</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalUnidades = 0;
                    $totalCosto = 0;
                @endphp
                @foreach ($ordenes as $orden)
                <tr>
                    <td>{{ $orden->trabajador_nombre }}</td>
                    <td>{{ $orden->producto_nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($orden->fecha)->format('d-m-Y') }}</td>
                    <td>{{ $orden->numero_orden_trabajo }}</td>
                    <td>{{ ucfirst($orden->tipo) }}</td>
                    <td>{{ $orden->descripcion ?? '-' }}</td>
                    <td>${{ number_format($orden->costo, 2, ',', '.') }}</td>
                </tr>
                @php
                    $totalUnidades++;
                    $totalCosto += $orden->costo;
                @endphp
                @endforeach
                <tr class="totals-row">
                    <td colspan="5">Total</td>
                    <td>{{ $totalUnidades }} Unidades</td>
                    <td>${{ number_format($totalCosto, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <button onclick="window.print()">Imprimir</button>
    </div>
</body>
</html>
