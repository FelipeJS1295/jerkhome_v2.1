@extends('layouts.app')

@section('content')
<div class="product-form-container">
    <header class="form-header">
        <h1>Crear Producto</h1>
        
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

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        
        <div class="form-sections">
            <!-- Información Básica -->
            <section class="form-section">
                <h2>Información Básica</h2>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="sku">SKU *</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required>
                        @error('sku')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="nombre">Nombre del Producto *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="esqueleto">Esqueleto *</label>
                        <input type="text" name="esqueleto" id="esqueleto" value="{{ old('esqueleto') }}" required>
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
                        <input type="text" name="sku_esqueleto" id="sku_esqueleto" value="{{ old('sku_esqueleto') }}">
                        @error('sku_esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="sku_hites">SKU Hites</label>
                        <input type="text" name="sku_hites" id="sku_hites" value="{{ old('sku_hites') }}">
                        @error('sku_hites')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="sku_la_polar">SKU La Polar</label>
                        <input type="text" name="sku_la_polar" id="sku_la_polar" value="{{ old('sku_la_polar') }}">
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
                        <input type="file" name="imagen_corte" id="imagen_corte">
                        @error('imagen_corte')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_tapizado">Imagen Tapizado</label>
                        <input type="file" name="imagen_tapizado" id="imagen_tapizado">
                        @error('imagen_tapizado')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_corte_esqueleto">Imagen Corte Esqueleto</label>
                        <input type="file" name="imagen_corte_esqueleto" id="imagen_corte_esqueleto">
                        @error('imagen_corte_esqueleto')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field upload-field">
                        <label for="imagen_esqueleto">Imagen Esqueleto</label>
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
                        <input type="number" step="0.01" name="costo_costura" id="costo_costura" value="{{ old('costo_costura') }}">
                        @error('costo_costura')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_tapiceria">Costo Tapicería</label>
                        <input type="number" step="0.01" name="costo_tapiceria" id="costo_tapiceria" value="{{ old('costo_tapiceria') }}">
                        @error('costo_tapiceria')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_esqueleteria">Costo Esqueletería</label>
                        <input type="number" step="0.01" name="costo_esqueleteria" id="costo_esqueleteria" value="{{ old('costo_esqueleteria') }}">
                        @error('costo_esqueleteria')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_armado">Costo Armado</label>
                        <input type="number" step="0.01" name="costo_armado" id="costo_armado" value="{{ old('costo_armado') }}">
                        @error('costo_armado')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label for="costo_corte">Costo Corte</label>
                        <input type="number" step="0.01" name="costo_corte" id="costo_corte" value="{{ old('costo_corte') }}">
                        @error('costo_corte')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            <!-- Insumos -->
            <section class="form-section">
                <h2>Insumos Requeridos</h2>
                <div id="insumos-container">
                    <div class="insumo-row">
                        <select name="insumos[0][id]">
                            <option value="">Seleccionar Insumo</option>
                            @foreach($insumos as $insumo)
                                <option value="{{ $insumo->id }}" {{ old('insumos.0.id') == $insumo->id ? 'selected' : '' }}>
                                    {{ $insumo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="insumos[0][cantidad]" placeholder="Cantidad" value="{{ old('insumos.0.cantidad') }}" required>
                        <button type="button" class="btn-remove remove-insumo">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" id="add-insumo" class="btn-add">
                    <i class="fas fa-plus"></i> Agregar Insumo
                </button>
            </section>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
    let insumoIndex = 1;

    document.getElementById('add-insumo').addEventListener('click', function () {
        const container = document.getElementById('insumos-container');
        const newRow = container.firstElementChild.cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(function (element) {
            const name = element.getAttribute('name');
            if (name) {
                element.setAttribute('name', name.replace(/\d+/, insumoIndex));
                element.value = '';
            }
        });

        container.appendChild(newRow);
        insumoIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-insumo')) {
            const rowCount = document.querySelectorAll('.insumo-row').length;
            if (rowCount > 1) {
                e.target.closest('.insumo-row').remove();
            }
        }
    });
</script>
@endsection