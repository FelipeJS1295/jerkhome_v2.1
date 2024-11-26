@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Listado de Producción</h1>
            <span class="text-gray-600">Total: {{ $produccion->total() }} órdenes</span>
        </div>
        
        <div class="flex gap-4">
        <button type="button" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-150"
            data-bs-toggle="modal" 
            data-bs-target="#generateReportModal">
            <i class="fas fa-file-alt"></i> Generar Informe
        </button>
            
            <a href="{{ route('produccion.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-150">
                <i class="fas fa-plus-circle"></i>
                Nueva Orden de Trabajo
            </a>

            <a href="{{ route('produccion.reparaciones') }}" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-150">
                <i class="fas fa-tools"></i>
                Registrar Reparaciones
            </a>
        </div>
    </header>

    <form method="GET" action="{{ route('produccion.index') }}" class="bg-white p-6 rounded-lg shadow-md mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1" for="trabajador_id">Trabajador</label>
                <select name="trabajador_id" id="trabajador_id" class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach ($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}" {{ request('trabajador_id') == $trabajador->id ? 'selected' : '' }}>
                            {{ $trabajador->nombres }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1" for="fecha_desde">Fecha Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}" 
                    class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1" for="fecha_hasta">Fecha Hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                    class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1" for="numero_orden">N° Orden</label>
                <input type="text" name="numero_orden" id="numero_orden" value="{{ request('numero_orden') }}" 
                    placeholder="Buscar por N° Orden" class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg flex items-center gap-2 transition duration-150">
            <i class="fas fa-search"></i> Filtrar
        </button>
    </form>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Costo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">descripcion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($produccion as $orden)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $orden->trabajador_nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $orden->producto_nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($orden->fecha)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $orden->numero_orden_trabajo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($orden->costo !== null)
                                ${{ number_format($orden->costo, 2) }}
                            @else
                                No disponible
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $orden->tipo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $orden->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button type="button" 
                                    class="text-green-600 hover:text-green-900 transition duration-150" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#generateReportModal"
                                    data-trabajador="{{ $orden->trabajador_id }}"
                                    data-fecha="{{ $orden->fecha }}">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                                <a href="{{ route('produccion.edit', $orden->id) }}" 
                                    class="text-blue-600 hover:text-blue-900 transition duration-150">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produccion.destroy', $orden->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-red-600 hover:text-red-900 transition duration-150" 
                                        onclick="return confirm('¿Está seguro de eliminar esta orden?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50">
            {{ $produccion->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Modal Generar Informe -->
<div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Agregamos target="_blank" para abrir en una nueva pestaña -->
            <form action="{{ route('produccion.generateReport') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-xl font-semibold" id="generateReportModalLabel">Generar Informe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body space-y-4">
                    <!-- Trabajador -->
                    <div class="flex flex-col">
                        <label for="trabajador_id_report" class="text-sm font-medium text-gray-700 mb-1">Trabajador</label>
                        <select name="trabajador_id_report" id="trabajador_id_report" required 
                            class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            @foreach ($trabajadores as $trabajador)
                                <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha Desde -->
                    <div class="flex flex-col">
                        <label for="fecha_desde_report" class="text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                        <input type="date" name="fecha_desde_report" id="fecha_desde_report" required 
                            class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Fecha Hasta -->
                    <div class="flex flex-col">
                        <label for="fecha_hasta_report" class="text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta_report" id="fecha_hasta_report" required 
                            class="border rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Generar Informe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportModal = document.getElementById('generateReportModal');
    reportModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        if (button) {
            const trabajadorId = button.getAttribute('data-trabajador');
            const fecha = button.getAttribute('data-fecha');
            
            document.getElementById('trabajador_id_report').value = trabajadorId || '';
            document.getElementById('fecha_desde_report').value = fecha || '';
            document.getElementById('fecha_hasta_report').value = fecha || '';
        }
    });
});
</script>
@endsection