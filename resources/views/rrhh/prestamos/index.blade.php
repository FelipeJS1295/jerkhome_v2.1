@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
   <div class="flex justify-between items-center mb-6">
       <h1 class="text-2xl font-bold text-gray-800">Lista de Préstamos</h1>
       <a href="{{ route('rrhh.prestamos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
           <i class="fas fa-plus"></i>
           <span>Registrar Préstamo</span>
       </a>
   </div>

   <div class="overflow-x-auto shadow-lg rounded-lg">
       <table class="min-w-full bg-white divide-y divide-gray-200">
           <thead class="bg-gray-50">
               <tr>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuotas</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes Inicio</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
               </tr>
           </thead>
           <tbody class="divide-y divide-gray-200">
               @foreach($prestamos as $prestamo)
               <tr class="hover:bg-gray-50">
                   <td class="px-6 py-4">{{ $prestamo->nombres }} {{ $prestamo->apellidos }}</td>
                   <td class="px-6 py-4">{{ $prestamo->rut }}</td>
                   <td class="px-6 py-4 text-blue-600 font-medium">${{ number_format($prestamo->monto, 2) }}</td>
                   <td class="px-6 py-4">{{ $prestamo->cuotas }}</td>
                   <td class="px-6 py-4">{{ date('F Y', strtotime($prestamo->mes_inicio)) }}</td>
                   <td class="px-6 py-4 space-x-2">
                       <form action="{{ route('rrhh.prestamos.registrar_pago', $prestamo->id) }}" method="POST" class="inline">
                           @csrf
                           <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                               <i class="fas fa-money-bill-wave mr-1"></i> Registrar Pago
                           </button>
                       </form>
                       
                       <a href="{{ route('rrhh.prestamos.aplazar_cuota', $prestamo->id) }}" 
                          class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm inline-flex items-center">
                           <i class="fas fa-calendar-plus mr-1"></i> Aplazar Cuota
                       </a>
                       
                       <a href="{{ route('rrhh.prestamos.edit', $prestamo->id) }}" 
                          class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-md text-sm inline-flex items-center">
                           <i class="fas fa-edit mr-1"></i> Editar
                       </a>
                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
   </div>
</div>
@endsection
