@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Editar Proveedor</h1>

    <form action="{{ route('configuracion.proveedores.update', $proveedor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- RUT -->
        <div class="mb-4">
            <label for="rut" class="block text-gray-700">RUT</label>
            <input 
                type="text" 
                name="rut" 
                id="rut" 
                value="{{ old('rut', $proveedor->rut) }}" 
                class="border rounded w-full py-2 px-3 mt-1" 
                required 
                readonly
            >
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                value="{{ old('nombre', $proveedor->nombre) }}" 
                class="border rounded w-full py-2 px-3 mt-1" 
                required
            >
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email', $proveedor->email) }}" 
                class="border rounded w-full py-2 px-3 mt-1" 
                required
            >
        </div>

        <!-- Contacto -->
        <div class="mb-4">
            <label for="contacto" class="block text-gray-700">Contacto</label>
            <input 
                type="text" 
                name="contacto" 
                id="contacto" 
                value="{{ old('contacto', $proveedor->contacto) }}" 
                class="border rounded w-full py-2 px-3 mt-1" 
                required
            >
        </div>

        <!-- Botones -->
        <div class="flex justify-between items-center mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
            <a href="{{ route('configuracion.proveedores.index') }}" class="text-gray-600 hover:text-gray-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
