@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Agregar Proveedor</h1>
                <p class="mt-2 text-base text-gray-600">Ingrese los datos del nuevo proveedor para registrarlo en el sistema.</p>
            </div>

            <!-- Card del Formulario -->
            <div class="bg-white shadow-lg rounded-lg">
                <div class="px-6 py-8">
                    <form action="{{ route('configuracion.proveedores.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- RUT -->
                        <div class="space-y-2">
                            <label for="rut" class="block text-base font-medium text-gray-700">
                                RUT
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" 
                                       name="rut" 
                                       id="rut" 
                                       class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-base @error('rut') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="12.345.678-9"
                                       required>
                                @error('rut')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('rut')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="space-y-2">
                            <label for="nombre" class="block text-base font-medium text-gray-700">
                                Nombre o Razón Social
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-base @error('nombre') border-red-300 @enderror"
                                   placeholder="Nombre completo del proveedor"
                                   required>
                            @error('nombre')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid de 2 columnas para email y contacto -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-base font-medium text-gray-700">
                                    Correo Electrónico
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="block w-full pl-10 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-base @error('email') border-red-300 @enderror"
                                           placeholder="ejemplo@correo.com"
                                           required>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contacto -->
                            <div class="space-y-2">
                                <label for="contacto" class="block text-base font-medium text-gray-700">
                                    Teléfono de Contacto
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="contacto" 
                                           id="contacto" 
                                           class="block w-full pl-10 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-base @error('contacto') border-red-300 @enderror"
                                           placeholder="+56 9 1234 5678"
                                           required>
                                </div>
                                @error('contacto')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('configuracion.proveedores.index') }}" 
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
                                Guardar Proveedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
