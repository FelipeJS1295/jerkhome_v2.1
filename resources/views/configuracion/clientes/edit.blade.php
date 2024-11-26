@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Editar Cliente</h1>

    <!-- Mostrar mensajes de éxito o error -->
    @if (session('success'))
        <div class="bg-green-200 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-200 text-red-700 p-4 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('configuracion.clientes.update', $cliente->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        @csrf
        @method('PUT')

        <!-- Campo para el RUT -->
        <div class="mb-4">
            <label for="rut" class="block text-gray-700 font-semibold">RUT</label>
            <input type="text" name="rut" id="rut" value="{{ old('rut', $cliente->rut) }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500" required>
            @error('rut')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Campo para el Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500" required>
            @error('nombre')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Campo para el Tipo de Cliente -->
        <div class="mb-4">
            <label for="tipo" class="block text-gray-700 font-semibold">Tipo de Cliente</label>
            <select name="tipo" id="tipo" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500">
                <option value="Retail" {{ old('tipo', $cliente->tipo) == 'Retail' ? 'selected' : '' }}>Retail</option>
                <option value="Regional" {{ old('tipo', $cliente->tipo) == 'Regional' ? 'selected' : '' }}>Regional</option>
                <option value="Outlet" {{ old('tipo', $cliente->tipo) == 'Outlet' ? 'selected' : '' }}>Outlet</option>
                <option value="Varios" {{ old('tipo', $cliente->tipo) == 'Varios' ? 'selected' : '' }}>Varios</option>
            </select>
            @error('tipo')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botón para guardar -->
        <div class="flex justify-end">
            <a href="{{ route('configuracion.clientes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-4 hover:bg-gray-600">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
