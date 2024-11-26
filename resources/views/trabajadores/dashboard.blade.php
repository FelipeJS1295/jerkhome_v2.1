@extends('layouts.apptrabajadores')

@section('title', 'Dashboard Trabajadores')

@section('content')
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <!-- Botón Producción -->
    <a href="{{ url('/trabajadores/produccion') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow-md hover:bg-blue-600 flex flex-col items-center">
        <i class="fas fa-industry text-4xl mb-2"></i>
        <span class="text-lg font-bold">Producción</span>
    </a>

    <!-- Botón RRHH -->
    <a href="{{ url('/trabajadores/rrhh') }}" class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 flex flex-col items-center">
        <i class="fas fa-users text-4xl mb-2"></i>
        <span class="text-lg font-bold">RRHH</span>
    </a>

    <!-- Botón Tickets -->
    <a href="{{ url('/trabajadores/tickets') }}" class="bg-red-500 text-white p-4 rounded-lg shadow-md hover:bg-red-600 flex flex-col items-center">
        <i class="fas fa-ticket-alt text-4xl mb-2"></i>
        <span class="text-lg font-bold">Tickets</span>
    </a>
</div>
@endsection
