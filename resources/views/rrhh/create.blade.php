@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Agregar Trabajador</h1>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rrhh.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Usuario -->
                    <div class="col-span-2">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                        <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="" selected disabled>Seleccione un usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nombre_usuario }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Información Personal -->
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">RUT</label>
                        <input type="text" name="rut" id="rut" value="{{ old('rut') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Contacto -->
                    <div class="col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Previsión Social -->
                    <div>
                        <label for="afp" class="block text-sm font-medium text-gray-700 mb-1">AFP</label>
                        <select name="afp" id="afp" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="" selected disabled>Seleccione una AFP</option>
                            <option value="AFP Habitat">AFP Habitat</option>
                            <option value="AFP Cuprum">AFP Cuprum</option>
                            <option value="AFP Capital">AFP Capital</option>
                            <option value="AFP Provida">AFP Provida</option>
                            <option value="AFP Modelo">AFP Modelo</option>
                        </select>
                    </div>

                    <div>
                        <label for="salud" class="block text-sm font-medium text-gray-700 mb-1">Salud</label>
                        <select name="salud" id="salud" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="" selected disabled>Seleccione una entidad de salud</option>
                            <option value="Fonasa">Fonasa</option>
                            <option value="Isapre Colmena">Isapre Colmena</option>
                            <option value="Isapre Cruz Blanca">Isapre Cruz Blanca</option>
                            <option value="Isapre Banmédica">Isapre Banmédica</option>
                            <option value="Isapre Vida Tres">Isapre Vida Tres</option>
                        </select>
                    </div>

                    <!-- Información Laboral -->
                    <div>
                        <label for="sueldo" class="block text-sm font-medium text-gray-700 mb-1">Sueldo</label>
                        <input type="number" step="0.01" name="sueldo" id="sueldo" value="{{ old('sueldo') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso</label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Tallas -->
                    <div>
                        <label for="talla_polera" class="block text-sm font-medium text-gray-700 mb-1">Talla de Polera</label>
                        <input type="text" name="talla_polera" id="talla_polera" value="{{ old('talla_polera') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="talla_zapatos" class="block text-sm font-medium text-gray-700 mb-1">Talla de Zapatos</label>
                        <input type="text" name="talla_zapatos" id="talla_zapatos" value="{{ old('talla_zapatos') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label for="talla_pantalon" class="block text-sm font-medium text-gray-700 mb-1">Talla de Pantalón</label>
                        <input type="text" name="talla_pantalon" id="talla_pantalon" value="{{ old('talla_pantalon') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
