@extends('layouts.app')

@section('content')
<div class="finanzas-dashboard p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel de Finanzas</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tarjeta Créditos -->
        <div class="card bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="card-icon text-blue-500 text-4xl mr-4">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700">Créditos</h3>
                    <p class="text-gray-500 text-sm">Gestión de créditos financieros</p>
                </div>
            </div>
            <a href="{{ route('finanzas.creditos.index') }}" class="mt-4 block text-blue-600 font-medium">Ir a Créditos →</a>
        </div>

        <!-- Tarjeta Ingreso de Factura de Compras -->
        <div class="card bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="card-icon text-green-500 text-4xl mr-4">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700">Ingreso de Factura de Compras</h3>
                    <p class="text-gray-500 text-sm">Registrar facturas de compras</p>
                </div>
            </div>
            <a href="{{ route('finanzas.facturas.index') }}" class="mt-4 block text-green-600 font-medium">Ir a Facturas →</a>
        </div>

        <!-- Tarjeta Ingreso de Boletas Extras -->
        <div class="card bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="card-icon text-orange-500 text-4xl mr-4">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700">Ingreso de Boletas Extras</h3>
                    <p class="text-gray-500 text-sm">Registrar boletas adicionales</p>
                </div>
            </div>
            <a href="{{ route('finanzas.boletas.index') }}" class="mt-4 block text-orange-600 font-medium">Ir a Boletas →</a>
        </div>

        <!-- Tarjeta Gastos Extras -->
        <div class="card bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="card-icon text-red-500 text-4xl mr-4">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700">Gastos Extras</h3>
                    <p class="text-gray-500 text-sm">Control de gastos adicionales</p>
                </div>
            </div>
            <a href="{{ route('finanzas.gastos.index') }}" class="mt-4 block text-red-600 font-medium">Ir a Gastos →</a>
        </div>

        <!-- Tarjeta IVA -->
        <div class="card bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="card-icon text-purple-500 text-4xl mr-4">
                    <i class="fas fa-percentage"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700">IVA</h3>
                    <p class="text-gray-500 text-sm">Gestión del impuesto IVA</p>
                </div>
            </div>
            <a href="{{ route('finanzas.iva.index') }}" class="mt-4 block text-purple-600 font-medium">Ir a IVA →</a>
        </div>
    </div>
</div>
@endsection
