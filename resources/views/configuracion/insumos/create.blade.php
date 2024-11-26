@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Crear Insumo</h1>
                <p class="mt-2 text-base text-gray-600">Complete los detalles del nuevo insumo para registrarlo en el sistema.</p>
            </div>

            <!-- Card del Formulario -->
            <div class="bg-white shadow-lg rounded-lg">
                <div class="px-6 py-8">
                    <form action="{{ route('insumos.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Grid para SKU Padre e Hijo -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- SKU Padre -->
                            <div class="space-y-2">
                                <label for="sku_padre" class="block text-base font-medium text-gray-700">
                                    SKU Padre
                                </label>
                                <input type="text" 
                                       name="sku_padre" 
                                       id="sku_padre" 
                                       class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('sku_padre') border-red-300 @enderror"
                                       placeholder="SKU-001"
                                       required>
                                @error('sku_padre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU Hijo -->
                            <div class="space-y-2">
                                <label for="sku_hijo" class="block text-base font-medium text-gray-700">
                                    SKU Hijo
                                </label>
                                <input type="text" 
                                       name="sku_hijo" 
                                       id="sku_hijo" 
                                       class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('sku_hijo') border-red-300 @enderror"
                                       placeholder="SKU-001-A">
                                @error('sku_hijo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="space-y-2">
                            <label for="nombre" class="block text-base font-medium text-gray-700">
                                Nombre del Insumo
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('nombre') border-red-300 @enderror"
                                   placeholder="Nombre del insumo"
                                   required>
                            @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid para Unidad de Medida y Proveedor -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Unidad de Medida -->
                            <div class="space-y-2">
                                <label for="unidad_medida" class="block text-base font-medium text-gray-700">
                                    Unidad de Medida
                                </label>
                                <select name="unidad_medida" 
                                        id="unidad_medida" 
                                        class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('unidad_medida') border-red-300 @enderror"
                                        required>
                                    <option value="">Seleccione una unidad</option>
                                    <optgroup label="Longitud">
                                        <option value="mm">Milímetros (mm)</option>
                                        <option value="cm">Centímetros (cm)</option>
                                        <option value="m">Metros (m)</option>
                                    </optgroup>
                                    <optgroup label="Peso">
                                        <option value="g">Gramos (g)</option>
                                        <option value="kg">Kilogramos (kg)</option>
                                    </optgroup>
                                    <optgroup label="Volumen">
                                        <option value="ml">Mililitros (ml)</option>
                                        <option value="l">Litros (l)</option>
                                        <option value="m3">Metros cúbicos (m³)</option>
                                    </optgroup>
                                    <optgroup label="Área">
                                        <option value="cm2">Centímetros cuadrados (cm²)</option>
                                        <option value="m2">Metros cuadrados (m²)</option>
                                    </optgroup>
                                    <optgroup label="Cantidad">
                                        <option value="und">Unidades (und)</option>
                                        <option value="doc">Docenas (doc)</option>
                                        <option value="par">Pares (par)</option>
                                        <option value="pza">Piezas (pza)</option>
                                        <option value="rol">Rollos (rol)</option>
                                    </optgroup>
                                </select>
                                @error('unidad_medida')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Proveedor -->
                            <div class="space-y-2">
                                <label for="proveedor_id" class="block text-base font-medium text-gray-700">
                                    Proveedor
                                </label>
                                <select name="proveedor_id" 
                                        id="proveedor_id" 
                                        class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('proveedor_id') border-red-300 @enderror"
                                        required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Grid para Precios -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Precio Costo -->
                            <div class="space-y-2">
                                <label for="precio_costo" class="block text-base font-medium text-gray-700">
                                    Precio de Costo
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" 
                                           name="precio_costo" 
                                           id="precio_costo" 
                                           class="block w-full pl-7 rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('precio_costo') border-red-300 @enderror"
                                           step="0.01"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('precio_costo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio Venta -->
                            <div class="space-y-2">
                                <label for="precio_venta" class="block text-base font-medium text-gray-700">
                                    Precio de Venta
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" 
                                           name="precio_venta" 
                                           id="precio_venta" 
                                           class="block w-full pl-7 rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-base @error('precio_venta') border-red-300 @enderror"
                                           step="0.01"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('precio_venta')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('insumos.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar Insumo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection