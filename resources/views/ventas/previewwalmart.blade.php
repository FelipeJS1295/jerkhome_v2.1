@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Previsualización de Ventas</h1>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número de Orden</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Entrega</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Pago Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($ventas as $venta)
                <tr class="{{ $venta['ya_existe'] ? 'bg-red-100' : 'hover:bg-gray-50' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $venta['numero_orden'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $venta['fecha_entrega'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $venta['sku'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $venta['producto'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($venta['precio_cliente'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 eliminar-fila" 
                                data-orden="{{ $venta['numero_orden'] }}">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <form action="{{ route('ventas.guardarPreviewWalmart') }}" method="POST">
            @csrf
            <input type="hidden" name="ventas" value="{{ json_encode($ventas) }}">
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Guardar Ventas Nuevas
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const eliminarBotones = document.querySelectorAll('.eliminar-fila');

        eliminarBotones.forEach(boton => {
            boton.addEventListener('click', function () {
                const numeroOrden = this.getAttribute('data-orden');

                // Encuentra la fila asociada y elimínala del DOM
                const fila = this.closest('tr');
                fila.remove();

                // Opcional: Actualiza la lista de ventas en el formulario de envío
                const ventasInput = document.querySelector('input[name="ventas"]');
                if (ventasInput) {
                    let ventas = JSON.parse(ventasInput.value);
                    ventas = ventas.filter(venta => venta.numero_orden !== numeroOrden);
                    ventasInput.value = JSON.stringify(ventas);
                }
            });
        });
    });
</script>
@endsection

