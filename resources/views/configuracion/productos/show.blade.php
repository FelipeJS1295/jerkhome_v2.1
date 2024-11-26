@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <!-- Encabezado del Producto -->
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold leading-6 text-gray-900">{{ $producto->nombre }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">SKU: {{ $producto->sku }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('productos.edit', $producto->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- Columna Izquierda -->
            <div class="space-y-6">
                <!-- SKUs Relacionados -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">SKUs Relacionados</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">SKU Esqueleto:</span>
                            <span class="font-medium">{{ $producto->sku_esqueleto ?? 'No especificado' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">SKU Hites:</span>
                            <span class="font-medium">{{ $producto->sku_hites ?? 'No especificado' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">SKU La Polar:</span>
                            <span class="font-medium">{{ $producto->sku_la_polar ?? 'No especificado' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Costos de Producción -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Costos de Producción</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Costo Costura -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <button type="button" onclick="openImageModal('imagen-costura')" class="flex items-center text-gray-600 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                <span>Costura</span>
                            </button>
                            <span class="font-medium">${{ number_format($producto->costo_costura, 2) }}</span>
                        </div>

                        <!-- Costo Tapicería -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <button type="button" onclick="openImageModal('imagen-tapizado')" class="flex items-center text-gray-600 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span>Tapicería</span>
                            </button>
                            <span class="font-medium">${{ number_format($producto->costo_tapiceria, 2) }}</span>
                        </div>

                        <!-- Costo Esqueletería -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <button type="button" onclick="openImageModal('imagen-esqueleto')" class="flex items-center text-gray-600 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Esqueletería</span>
                            </button>
                            <span class="font-medium">${{ number_format($producto->costo_esqueleteria, 2) }}</span>
                        </div>

                        <!-- Total de Costos Principales -->
                        <div class="col-span-2 mt-4 p-4 bg-blue-50 rounded-lg border-t-4 border-blue-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-blue-800 font-medium">Total Costos Principales</span>
                                    <p class="text-sm text-blue-600">(Costura + Tapicería + Esqueletería)</p>
                                </div>
                                <span class="text-xl font-bold text-blue-800">
                                    ${{ number_format($producto->costo_costura + $producto->costo_tapiceria + $producto->costo_esqueleteria, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="space-y-6">
                <!-- Insumos Requeridos -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Insumos Requeridos</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU Padre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insumo</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Prom.</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Variantes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($insumosConPromedio as $insumo)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $insumo->sku_padre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $insumo->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        {{ $insumo->cantidad }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        ${{ number_format($insumo->precio_promedio, 2) }}
                                        <div class="text-xs text-gray-400">Promedio de {{ $insumo->total_variantes }} variantes</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                        ${{ number_format($insumo->cantidad * $insumo->precio_promedio, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $insumo->total_variantes }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- Fila de Total -->
                                <tr class="bg-gray-50 font-medium">
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        Total Insumos:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-bold">
                                        ${{ number_format($insumosConPromedio->sum(function($insumo) {
                                            return $insumo->cantidad * $insumo->precio_promedio;
                                        }), 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Imágenes -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Vista de Imagen</h3>
            <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="Imagen del producto" class="w-full h-auto">
        </div>
    </div>
</div>

<script>
    // Función para abrir el modal de imágenes
    function openImageModal(imageType) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        
        let imageUrl = '';
        let title = '';
        
        switch(imageType) {
            case 'imagen-corte':
                imageUrl = "{{ $producto->imagen_corte ? asset('storage/' . $producto->imagen_corte) : '' }}";
                title = 'Imagen de Corte';
                break;
            case 'imagen-tapizado':
                imageUrl = "{{ $producto->imagen_tapizado ? asset('storage/' . $producto->imagen_tapizado) : '' }}";
                title = 'Imagen de Tapizado';
                break;
            case 'imagen-corte-esqueleto':
                imageUrl = "{{ $producto->imagen_corte_esqueleto ? asset('storage/' . $producto->imagen_corte_esqueleto) : '' }}";
                title = 'Imagen de Corte Esqueleto';
                break;
            case 'imagen-esqueleto':
                imageUrl = "{{ $producto->imagen_esqueleto ? asset('storage/' . $producto->imagen_esqueleto) : '' }}";
                title = 'Imagen de Esqueleto';
                break;
        }
        
        if (imageUrl) {
            modalImage.src = imageUrl;
            modalTitle.textContent = title;
            modal.classList.remove('hidden');
            
            // Prevenir scroll en el body
            document.body.style.overflow = 'hidden';
        }
    }

    // Función para cerrar el modal
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        
        // Restaurar scroll en el body
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal con la tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });

    // Cerrar modal al hacer clic fuera de la imagen
    document.getElementById('imageModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeImageModal();
        }
    });
</script>

<style>
    /* Estilos adicionales para el modal y las imágenes */
    .aspect-video {
        aspect-ratio: 16 / 9;
    }

    #modalImage {
        max-height: 80vh;
        object-fit: contain;
    }

    /* Animaciones para el modal */
    #imageModal:not(.hidden) {
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Estilos para las tarjetas de costos */
    .cost-card:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }

    /* Estilos para la tabla de insumos */
    .table-hover tr:hover {
        background-color: rgba(249, 250, 251, 0.5);
    }
</style>
@endsection