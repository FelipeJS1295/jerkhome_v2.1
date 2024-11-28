@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Recursos Humanos</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Lista de Trabajadores -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-blue-500 text-4xl mb-4">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Lista de Trabajadores</h3>
                <p class="text-gray-600 mb-4">Total: {{ $trabajadores->count() }}</p>
                <a href="{{ route('rrhh.trabajadores.index') }}" 
                   class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
                    Ver Lista
                </a>
            </div>

            <!-- Planilla de Sueldos -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-green-500 text-4xl mb-4">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Planilla de Sueldos</h3>
                <p class="text-gray-600 mb-4">Gestión de salarios</p>
                <a href="{{ route('rrhh.planilla_sueldos.index') }}" 
                   class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-300">
                    Ir a Planilla
                </a>
            </div>

            <!-- Horas Extras -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-purple-500 text-4xl mb-4">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Horas Extras</h3>
                <p class="text-gray-600 mb-4">Registrar horas extras</p>
                <a href="{{ route('rrhh.horas_extras.index') }}" 
                   class="inline-block px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition-colors duration-300">
                    Registrar
                </a>
            </div>

            <!-- Faltas -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-red-500 text-4xl mb-4">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Faltas</h3>
                <p class="text-gray-600 mb-4">Registrar faltas</p>
                <a href="{{ route('rrhh.faltas.index') }}" 
                   class="inline-block px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-300">
                    Registrar
                </a>
            </div>

            <!-- Vacaciones -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-yellow-500 text-4xl mb-4">
                    <i class="fas fa-umbrella-beach"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Vacaciones</h3>
                <p class="text-gray-600 mb-4">Registrar vacaciones</p>
                <a href="{{ route('rrhh.vacaciones.index') }}" 
                   class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors duration-300">
                    Registrar
                </a>
            </div>

            <!-- Quincenas -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-indigo-500 text-4xl mb-4">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Quincenas</h3>
                <p class="text-gray-600 mb-4">Registrar y gestionar quincenas</p>
                <a href="{{ route('rrhh.quincenas.index') }}" 
                   class="inline-block px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition-colors duration-300">
                    Ir a Quincenas
                </a>
            </div>

            <!-- Anticipos -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="text-pink-500 text-4xl mb-4">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Anticipos</h3>
                <p class="text-gray-600 mb-4">Registrar y gestionar anticipos</p>
                <a href="{{ route('rrhh.anticipos.index') }}" 
                   class="inline-block px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-600 transition-colors duration-300">
                    Ir a Anticipos
                </a>
            </div>

            <!-- Préstamos -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6 flex flex-col items-center">
                    <div class="mb-4 p-3 bg-cyan-100 rounded-full">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Préstamos</h3>
                    <p class="text-gray-600 text-center mb-6">Registrar y gestionar préstamos</p>
                    <a href="{{ route('rrhh.prestamos.index') }}" 
                    class="w-full bg-gradient-to-r from-cyan-500 to-cyan-600 text-white py-2 px-4 rounded-lg font-medium text-center hover:from-cyan-600 hover:to-cyan-700 transition-all duration-300 shadow-md hover:shadow-lg">
                        Ir a Préstamos
                    </a>
                </div>
            </div>

            <!-- Bonos -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex flex-col items-center">
                    <div class="bg-orange-100 p-4 rounded-full mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Bonos</h3>
                    <p class="text-gray-600 mb-4">Registrar bonos</p>
                    <a href="{{ route('rrhh.bonos.index') }}" class="w-full text-center px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors duration-300">
                        Registrar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection