@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Editar Usuario</h1>
                <p class="mt-2 text-sm text-gray-600">Modifique los campos necesarios para actualizar los datos del usuario.</p>
            </div>

            <!-- Card del Formulario -->
            <div class="bg-white shadow-lg rounded-lg px-6 py-8">
                <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') <!-- Método PUT para la actualización -->

                    <!-- Nombre Usuario -->
                    <div>
                        <label for="nombre_usuario" class="block text-base font-medium text-gray-700 mb-2">
                            Nombre de Usuario
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" 
                                   name="nombre_usuario" 
                                   id="nombre_usuario" 
                                   class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-base @error('nombre_usuario') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                   value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" 
                                   required>
                        </div>
                        @error('nombre_usuario')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-base font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-base @error('email') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                   value="{{ old('email', $usuario->email) }}" 
                                   required>
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid de 2 columnas para rol y estado -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Rol -->
                        <div>
                            <label for="rol" class="block text-base font-medium text-gray-700 mb-2">
                                Rol del Usuario
                            </label>
                            <select name="rol" 
                                    id="rol" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md @error('rol') border-red-300 @enderror" 
                                    required>
                                <option value="" disabled>Seleccione un rol</option>
                                <option value="Admin" {{ old('rol', $usuario->rol) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Users" {{ old('rol', $usuario->rol) == 'Users' ? 'selected' : '' }}>Users</option>
                                <option value="Tapicería" {{ old('rol', $usuario->rol) == 'Tapicería' ? 'selected' : '' }}>Tapicería</option>
                                <option value="Costura" {{ old('rol', $usuario->rol) == 'Costura' ? 'selected' : '' }}>Costura</option>
                                <option value="Esqueletería" {{ old('rol', $usuario->rol) == 'Esqueletería' ? 'selected' : '' }}>Esqueletería</option>
                                <option value="Embalaje" {{ old('rol', $usuario->rol) == 'Embalaje' ? 'selected' : '' }}>Embalaje</option>
                                <option value="Corte" {{ old('rol', $usuario->rol) == 'Corte' ? 'selected' : '' }}>Corte</option>
                                <option value="Cojinería" {{ old('rol', $usuario->rol) == 'Cojinería' ? 'selected' : '' }}>Cojinería</option>
                                <option value="Bodega" {{ old('rol', $usuario->rol) == 'Bodega' ? 'selected' : '' }}>Bodega</option>
                            </select>
                            @error('rol')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label for="password" class="block text-base font-medium text-gray-700 mb-2">
                                Contraseña (opcional)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" 
                                    name="password" 
                                    id="password" 
                                    class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-base" 
                                    placeholder="Dejar en blanco para mantener la contraseña actual">
                            </div>
                        </div>


                        <!-- Estado -->
                        <div>
                            <label for="activo" class="block text-base font-medium text-gray-700 mb-2">
                                Estado del Usuario
                            </label>
                            <select name="activo" 
                                    id="activo" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md @error('activo') border-red-300 @enderror" 
                                    required>
                                <option value="1" {{ old('activo', $usuario->activo) == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('activo', $usuario->activo) == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('activo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-3 pt-6">
                        <a href="{{ route('usuarios.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
