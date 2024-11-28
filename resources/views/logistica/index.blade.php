@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Logística</h1>

    <!-- Tarjetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Devoluciones -->
        <a href="{{ route('logistica.devoluciones.index') }}" class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="bg-red-100 text-red-500 rounded-full p-3">
                    <i class="fas fa-undo-alt fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Devoluciones</h2>
                    <p class="text-gray-600">Gestionar devoluciones</p>
                </div>
            </div>
        </a>

        <!-- Inventario -->
        <a href="{{ route('logistica.inventario.dashboard') }}" class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-500 rounded-full p-3">
                    <i class="fas fa-boxes fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Inventario</h2>
                    <p class="text-gray-600">Control de inventarios</p>
                </div>
            </div>
        </a>

        <!-- Despachos -->
        <a href="{{ route('logistica.despachos.index') }}" class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 text-green-500 rounded-full p-3">
                    <i class="fas fa-truck fa-2x"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Despachos</h2>
                    <p class="text-gray-600">Gestionar despachos</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection