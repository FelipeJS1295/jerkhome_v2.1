@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Crear Usuario</h1>
                <p class="mt-2 text-sm text-gray-600">Complete todos los campos para crear un nuevo usuario en el sistema.</p>
            </div>

            <!-- Card del Formulario -->
            <div class="bg-white shadow-lg rounded-lg px-6 py-8">
                <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
                    @csrf

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
                                   value="{{ old('nombre_usuario') }}" 
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
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid de 2 columnas para contraseñas -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Contraseña -->
                        <div>
                            <label for="password" class="block text-base font-medium text-gray-700 mb-2">
                                Contraseña
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-base @error('password') border-red-300 @enderror" 
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label for="password_confirmation" class="block text-base font-medium text-gray-700 mb-2">
                                Confirmar Contraseña
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-base" 
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
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
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="Admin">Admin</option>
                                <option value="Users">Users</option>
                                <option value="Tapicería">Tapicería</option>
                                <option value="Costura">Costura</option>
                                <option value="Esqueletería">Esqueletería</option>
                                <option value="Embalaje">Embalaje</option>
                                <option value="Corte">Corte</option>
                                <option value="Cojinería">Cojinería</option>
                                <option value="Bodega">Bodega</option>
                            </select>
                            @error('rol')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>Inactivo</option>
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
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para toggle de contraseña -->
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    
    // Cambia el ícono del ojo
    const button = input.nextElementSibling;
    const svg = button.querySelector('svg');
    
    if (type === 'text') {
        svg.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    } else {
        svg.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
    }
}
</script>
@endsection