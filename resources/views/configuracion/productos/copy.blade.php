@extends('layouts.app')

@section('content')
<div>
    <h1>Copiar Producto</h1>

    @if ($errors->any())
        <div>
            <strong>Por favor corrige los errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.storeCopy', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Información Básica -->
        <div>
            <h2>Información Básica</h2>
            <div>
                <label for="sku">SKU *</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku', $producto->sku) }}" required>
            </div>

            <div>
                <label for="nombre">Nombre del Producto *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div>
                <label for="esqueleto">Esqueleto *</label>
                <input type="text" name="esqueleto" id="esqueleto" value="{{ old('esqueleto', $producto->esqueleto) }}" required>
            </div>
        </div>

        <!-- SKUs Relacionados -->
        <div>
            <h2>SKUs Relacionados</h2>
            <div>
                <label for="sku_esqueleto">SKU Esqueleto</label>
                <input type="text" name="sku_esqueleto" id="sku_esqueleto" value="{{ old('sku_esqueleto', $producto->sku_esqueleto) }}">
            </div>

            <div>
                <label for="sku_hites">SKU Hites</label>
                <input type="text" name="sku_hites" id="sku_hites" value="{{ old('sku_hites', $producto->sku_hites) }}">
            </div>

            <div>
                <label for="sku_la_polar">SKU La Polar</label>
                <input type="text" name="sku_la_polar" id="sku_la_polar" value="{{ old('sku_la_polar', $producto->sku_la_polar) }}">
            </div>
        </div>

        <!-- Imágenes -->
        <div>
            <h2>Imágenes del Producto</h2>
            <div>
                <label for="imagen_corte">Imagen Corte</label>
                <input type="file" name="imagen_corte" id="imagen_corte">
            </div>

            <div>
                <label for="imagen_tapizado">Imagen Tapizado</label>
                <input type="file" name="imagen_tapizado" id="imagen_tapizado">
            </div>

            <div>
                <label for="imagen_corte_esqueleto">Imagen Corte Esqueleto</label>
                <input type="file" name="imagen_corte_esqueleto" id="imagen_corte_esqueleto">
            </div>

            <div>
                <label for="imagen_esqueleto">Imagen Esqueleto</label>
                <input type="file" name="imagen_esqueleto" id="imagen_esqueleto">
            </div>
        </div>

        <!-- Costos -->
        <div>
            <h2>Costos de Producción</h2>
            <div>
                <label for="costo_costura">Costo Costura</label>
                <input type="number" step="0.01" name="costo_costura" id="costo_costura" value="{{ old('costo_costura', $producto->costo_costura) }}">
            </div>

            <div>
                <label for="costo_tapiceria">Costo Tapicería</label>
                <input type="number" step="0.01" name="costo_tapiceria" id="costo_tapiceria" value="{{ old('costo_tapiceria', $producto->costo_tapiceria) }}">
            </div>

            <div>
                <label for="costo_esqueleteria">Costo Esqueletería</label>
                <input type="number" step="0.01" name="costo_esqueleteria" id="costo_esqueleteria" value="{{ old('costo_esqueleteria', $producto->costo_esqueleteria) }}">
            </div>

            <div>
                <label for="costo_armado">Costo Armado</label>
                <input type="number" step="0.01" name="costo_armado" id="costo_armado" value="{{ old('costo_armado', $producto->costo_armado) }}">
            </div>

            <div>
                <label for="costo_corte">Costo Corte</label>
                <input type="number" step="0.01" name="costo_corte" id="costo_corte" value="{{ old('costo_corte', $producto->costo_corte) }}">
            </div>
        </div>

        <!-- Insumos -->
        <div>
            <h2>Insumos Requeridos</h2>
            <div id="insumos-container">
                @foreach ($producto->insumos as $index => $insumo)
                <div class="insumo-row">
                    <select name="insumos[{{ $index }}][id]">
                        <option value="">Seleccionar Insumo</option>
                        @foreach($insumos as $option)
                            <option value="{{ $option->id }}" {{ $insumo->id == $option->id ? 'selected' : '' }}>
                                {{ $option->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="insumos[{{ $index }}][cantidad]" placeholder="Cantidad" value="{{ $insumo->pivot->cantidad }}" required>
                    <button type="button" class="remove-insumo">Eliminar</button>
                </div>
                @endforeach
            </div>
            <button type="button" id="add-insumo">Agregar Insumo</button>
        </div>

        <!-- Botón de envío -->
        <div>
            <button type="submit">Guardar Producto Copiado</button>
        </div>
    </form>
</div>

<script>
    let insumoIndex = {{ count($producto->insumos) }};

    document.getElementById('add-insumo').addEventListener('click', function () {
        const container = document.getElementById('insumos-container');
        const newRow = document.createElement('div');
        newRow.className = 'insumo-row';
        newRow.innerHTML = `
            <select name="insumos[${insumoIndex}][id]">
                <option value="">Seleccionar Insumo</option>
                @foreach($insumos as $insumo)
                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                @endforeach
            </select>
            <input type="number" name="insumos[${insumoIndex}][cantidad]" placeholder="Cantidad" required>
            <button type="button" class="remove-insumo">Eliminar</button>
        `;
        container.appendChild(newRow);
        insumoIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-insumo')) {
            const row = e.target.closest('.insumo-row');
            row.remove();
        }
    });
</script>
@endsection
