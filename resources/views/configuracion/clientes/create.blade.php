@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Título de la página -->
    <h1 class="text-3xl font-bold mb-8">Crear Cliente</h1>

    <!-- Formulario para crear un nuevo cliente -->
    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('configuracion.clientes.store') }}">
            @csrf

            <!-- Campo: RUT -->
            <div class="mb-6">
                <label for="rut" class="block text-gray-700 font-semibold">RUT</label>
                <input type="text" name="rut" id="rut" class="w-full mt-2 p-3 border border-gray-300 rounded" value="{{ old('rut') }}" placeholder="Ingrese el RUT del cliente" required>
                @error('rut')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo: Nombre -->
            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="w-full mt-2 p-3 border border-gray-300 rounded" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del cliente" required>
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo: Tipo -->
            <div class="mb-6">
                <label for="tipo" class="block text-gray-700 font-semibold">Tipo de Cliente</label>
                <select name="tipo" id="tipo" class="w-full mt-2 p-3 border border-gray-300 rounded" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Retail" {{ old('tipo') == 'Retail' ? 'selected' : '' }}>Retail</option>
                    <option value="Regional" {{ old('tipo') == 'Regional' ? 'selected' : '' }}>Regional</option>
                    <option value="Outlet" {{ old('tipo') == 'Outlet' ? 'selected' : '' }}>Outlet</option>
                    <option value="Varios" {{ old('tipo') == 'Varios' ? 'selected' : '' }}>Varios</option>
                </select>
                @error('tipo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end mt-8">
                <a href="{{ route('configuracion.clientes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-4">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Guardar Cliente</button>
            </div>
        </form>
    </div>
</div>
@endsection
