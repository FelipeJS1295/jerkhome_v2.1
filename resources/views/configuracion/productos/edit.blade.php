@extends('layouts.app')

@section('content')
<div class="product-form-container">
    <header class="form-header">
        <h1>Editar Producto</h1>
        
        @if ($errors->any())
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor corrige los errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </header>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        @method('PUT')
        
        <div class="form-sections">
            <!-- Información Básica -->
            <section class="form-section">
                <h2>Información Básica</h2>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="sku">SKU *</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $producto->sku) }}" required>
                        @error('sku')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="nombre">Nombre del Producto *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                        @error('nombre')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="esqueleto">Esqueleto *</label>
                        <input type="text" name="esqueleto" id="esqueleto" value="{{ old('esqueleto', $producto->esqueleto) }}" required>
                        @error('esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            <!-- SKUs Relacionados -->
            <section class="form-section">
                <h2>SKUs Relacionados</h2>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="sku_esqueleto">SKU Esqueleto</label>
                        <input type="text" name="sku_esqueleto" id="sku_esqueleto" value="{{ old('sku_esqueleto', $producto->sku_esqueleto) }}">
                        @error('sku_esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="sku_hites">SKU Hites</label>
                        <input type="text" name="sku_hites" id="sku_hites" value="{{ old('sku_hites', $producto->sku_hites) }}">
                        @error('sku_hites')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="sku_la_polar">SKU La Polar</label>
                        <input type="text" name="sku_la_polar" id="sku_la_polar" value="{{ old('sku_la_polar', $producto->sku_la_polar) }}">
                        @error('sku_la_polar')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            <!-- Imágenes -->
            <section class="form-section">
                <h2>Imágenes del Producto</h2>
                <div class="form-grid">
                    <div class="form-field upload-field">
                        <label for="imagen_corte">Imagen Corte</label>
                        @if($producto->imagen_corte)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $producto->imagen_corte) }}" alt="Imagen Corte" class="thumbnail">
                                <small>Imagen actual</small>
                            </div>
                        @endif
                        <input type="file" name="imagen_corte" id="imagen_corte">
                        @error('imagen_corte')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_tapizado">Imagen Tapizado</label>
                        @if($producto->imagen_tapizado)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $producto->imagen_tapizado) }}" alt="Imagen Tapizado" class="thumbnail">
                                <small>Imagen actual</small>
                            </div>
                        @endif
                        <input type="file" name="imagen_tapizado" id="imagen_tapizado">
                        @error('imagen_tapizado')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_corte_esqueleto">Imagen Corte Esqueleto</label>
                        @if($producto->imagen_corte_esqueleto)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $producto->imagen_corte_esqueleto) }}" alt="Imagen Corte Esqueleto" class="thumbnail">
                                <small>Imagen actual</small>
                            </div>
                        @endif
                        <input type="file" name="imagen_corte_esqueleto" id="imagen_corte_esqueleto">
                        @error('imagen_corte_esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_esqueleto">Imagen Esqueleto</label>
                        @if($producto->imagen_esqueleto)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $producto->imagen_esqueleto) }}" alt="Imagen Esqueleto" class="thumbnail">
                                <small>Imagen actual</small>
                            </div>
                        @endif
                        <input type="file" name="imagen_esqueleto" id="imagen_esqueleto">
                        @error('imagen_esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            <!-- Costos -->
            <section class="form-section">
                <h2>Costos de Producción</h2>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="costo_costura">Costo Costura</label>
                        <input type="number" name="costo_costura" id="costo_costura" value="{{ old('costo_costura', $producto->costo_costura) }}">
                        @error('costo_costura')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_tapiceria">Costo Tapicería</label>
                        <input type="number" name="costo_tapiceria" id="costo_tapiceria" value="{{ old('costo_tapiceria', $producto->costo_tapiceria) }}">
                        @error('costo_tapiceria')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_esqueleteria">Costo Esqueletería</label>
                        <input type="number" name="costo_esqueleteria" id="costo_esqueleteria" value="{{ old('costo_esqueleteria', $producto->costo_esqueleteria) }}">
                        @error('costo_esqueleteria')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_armado">Costo Armado</label>
                        <input type="number" name="costo_armado" id="costo_armado" value="{{ old('costo_armado', $producto->costo_armado) }}">
                        @error('costo_armado')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_corte">Costo Corte</label>
                        <input type="number" name="costo_corte" id="costo_corte" value="{{ old('costo_corte', $producto->costo_corte) }}">
                        @error('costo_corte')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            <!-- Insumos -->
            <section class="form-section">
                <h2>Insumos Requeridos</h2>
                <div id="insumos-container">
                    @forelse($producto->insumos as $index => $insumoRelacionado)
                        <div class="insumo-row">
                            <select name="insumos[{{ $index }}][id]" required>
                                <option value="">Seleccionar Insumo</option>
                                @foreach($insumos as $insumo)
                                    <option value="{{ $insumo->id }}" {{ $insumoRelacionado->id == $insumo->id ? 'selected' : '' }}>
                                        {{ $insumo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" 
                                   name="insumos[{{ $index }}][cantidad]" 
                                   value="{{ $insumoRelacionado->pivot->cantidad }}" 
                                   placeholder="Cantidad" 
                                   required>
                            <button type="button" class="btn-remove remove-insumo">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @empty
                        <div class="insumo-row">
                            <select name="insumos[0][id]" required>
                                <option value="">Seleccionar Insumo</option>
                                @foreach($insumos as $insumo)
                                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="insumos[0][cantidad]" placeholder="Cantidad" required>
                            <button type="button" class="btn-remove remove-insumo">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforelse
                </div>
                <button type="button" id="add-insumo" class="btn-add">
                    <i class="fas fa-plus"></i> Agregar Insumo
                </button>
            </section>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Actualizar Producto
            </button>
        </div>
    </form>
</div>

<style>
.current-image {
    margin-bottom: 10px;
}

.thumbnail {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    margin-bottom: 5px;
}

.insumo-row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.insumo-row select {
    flex: 2;
}

.insumo-row input {
    flex: 1;
}

.btn-remove {
    padding: 8px;
    background-color: #ef4444;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-remove:hover {
    background-color: #dc2626;
}
</style>

<script>
    let insumoIndex = {{ count($producto->insumos) > 0 ? count($producto->insumos) : 1 }};

    document.getElementById('add-insumo').addEventListener('click', function () {
        const container = document.getElementById('insumos-container');
        const template = container.firstElementChild.cloneNode(true);
        
        // Limpiar valores seleccionados
        template.querySelector('select').value = '';
        template.querySelector('input').value = '';
        
        // Actualizar índices
        template.querySelectorAll('select, input').forEach(function (element) {
            const name = element.getAttribute('name');
            if (name) {
                element.setAttribute('name', name.replace(/\d+/, insumoIndex));
            }
        });

        container.appendChild(template);
        insumoIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-insumo') || e.target.closest('.remove-insumo')) {
            const rowCount = document.querySelectorAll('.insumo-row').length;
            if (rowCount > 1) {
                e.target.closest('.insumo-row').remove();
            }
        }
    });
</script>
@endsection