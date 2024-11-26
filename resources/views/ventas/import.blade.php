@extends('layouts.app')

@section('content')
<div class="container">
    @if($errors->any())
    <div class="alert-error">
        <strong>Error:</strong> {{ $errors->first('error') }}
    </div>
    @endif

    <h1 class="page-title">Importar Ventas</h1>

    <div class="import-grid">
        <!-- Cencosud -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">Cencosud</h3>
                <form action="{{ route('ventas.import.cencosud') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo Excel</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button">Importar Cencosud</button>
                </form>
            </div>
        </div>

        <!-- Walmart -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">Walmart</h3>
                <form action="{{ route('ventas.import.walmart') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo Walmart</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button">Importar</button>
                </form>
            </div>
        </div>

        <!-- Falabella -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">Falabella</h3>
                <form action="{{ route('ventas.import.falabella') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo Falabella</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button">Importar Falabella</button>
                </form>
            </div>
        </div>

        <!-- La Polar -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">La Polar</h3>
                <form action="{{ route('ventas.import.lapolar') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo La Polar</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button">Importar La Polar</button>
                </form>
            </div>
        </div>

        <!-- Hites -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">Hites</h3>
                <form action="{{ route('ventas.import.hites') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo Hites</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button">Importar Hites</button>
                </form>
            </div>
        </div>

        <!-- Actualizar Órdenes Hites -->
        <div class="import-card">
            <div class="card-content">
                <h3 class="retailer-title">Actualizar Órdenes Hites</h3>
                <form action="{{ route('ventas.previewActualizarHites') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="form-group">
                        <label>Subir archivo Excel</label>
                        <input type="file" name="archivo" required>
                    </div>
                    <button type="submit" class="import-button preview">Previsualizar Actualización</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 2rem;
}

.alert-error {
    background-color: #fee2e2;
    border: 1px solid #ef4444;
    color: #991b1b;
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
}

.import-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.import-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.import-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.card-content {
    padding: 1.5rem;
}

.retailer-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1.5rem;
}

.import-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.form-group input[type="file"] {
    padding: 0.5rem;
    border: 1px dashed #d1d5db;
    border-radius: 0.375rem;
    background-color: #f9fafb;
    cursor: pointer;
    transition: border-color 0.2s;
}

.form-group input[type="file"]:hover {
    border-color: #6b7280;
}

.import-button {
    padding: 0.75rem 1rem;
    background-color: #4f46e5;
    color: white;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.import-button:hover {
    background-color: #4338ca;
}

.import-button.preview {
    background-color: #059669;
}

.import-button.preview:hover {
    background-color: #047857;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .import-grid {
        grid-template-columns: 1fr;
    }
}

</style>

@endsection

