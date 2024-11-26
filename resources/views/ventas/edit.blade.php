@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Orden de Venta</h1>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="text-red-700 font-medium">Errores:</div>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ventas.update', $venta->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="cliente_id" class="block text-sm font-medium text-gray-700">ID Cliente</label>
                        <input type="text" id="cliente_id" name="cliente_id" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('cliente_id', $venta->cliente_id) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="numero_orden" class="block text-sm font-medium text-gray-700">Número Orden</label>
                        <input type="text" id="numero_orden" name="numero_orden" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('numero_orden', $venta->numero_orden) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="cliente_final" class="block text-sm font-medium text-gray-700">Cliente Final</label>
                        <input type="text" id="cliente_final" name="cliente_final" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('cliente_final', $venta->cliente_final) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="rut_documento" class="block text-sm font-medium text-gray-700">RUT</label>
                        <input type="text" id="rut_documento" name="rut_documento" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('rut_documento', $venta->rut_documento) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('email', $venta->email) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('telefono', $venta->telefono) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="fecha_compra" class="block text-sm font-medium text-gray-700">Fecha Compra</label>
                        <input type="date" id="fecha_compra" name="fecha_compra" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('fecha_compra', $venta->fecha_compra) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="fecha_entrega" class="block text-sm font-medium text-gray-700">Fecha Entrega</label>
                        <input type="date" id="fecha_entrega" name="fecha_entrega" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('fecha_entrega', $venta->fecha_entrega) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="fecha_cliente" class="block text-sm font-medium text-gray-700">Fecha Cliente</label>
                        <input type="date" id="fecha_cliente" name="fecha_cliente" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('fecha_cliente', $venta->fecha_cliente) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input type="number" step="0.01" id="precio" name="precio" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('precio', $venta->precio) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="precio_cliente" class="block text-sm font-medium text-gray-700">Precio Cliente</label>
                        <input type="number" step="0.01" id="precio_cliente" name="precio_cliente" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('precio_cliente', $venta->precio_cliente) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="costo_despacho" class="block text-sm font-medium text-gray-700">Costo Despacho</label>
                        <input type="number" step="0.01" id="costo_despacho" name="costo_despacho" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('costo_despacho', $venta->costo_despacho) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="region" class="block text-sm font-medium text-gray-700">Región</label>
                        <input type="text" id="region" name="region" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('region', $venta->region) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="comuna" class="block text-sm font-medium text-gray-700">Comuna</label>
                        <input type="text" id="comuna" name="comuna" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('comuna', $venta->comuna) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" id="direccion" name="direccion" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('direccion', $venta->direccion) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                        <input type="text" id="sku" name="sku" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ old('sku', $venta->sku) }}">
                    </div>

                    <div class="space-y-2">
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="estado" name="estado" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="nueva" {{ old('estado', $venta->estado) == 'nueva' ? 'selected' : '' }}>Nueva</option>
                            <option value="procesando" {{ old('estado', $venta->estado) == 'procesando' ? 'selected' : '' }}>Procesando</option>
                            <option value="completado" {{ old('estado', $venta->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('ventas.index') }}" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection