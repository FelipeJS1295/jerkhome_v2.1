@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
   <div class="flex justify-between items-center mb-6">
       <h1 class="text-2xl font-bold text-gray-800">Lista de Quincenas</h1>
       <a href="{{ route('rrhh.quincenas.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
           <i class="fas fa-plus"></i>
           <span>Registrar Quincena</span>
       </a>
   </div>

   <div class="overflow-x-auto shadow-lg rounded-lg">
       <table class="min-w-full bg-white divide-y divide-gray-200">
           <thead class="bg-gray-50">
               <tr>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trabajador</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes</th>
               </tr>
           </thead>
           <tbody class="divide-y divide-gray-200">
               @foreach($quincenas as $quincena)
               <tr class="hover:bg-gray-50">
                   <td class="px-6 py-4">{{ $quincena->nombres }} {{ $quincena->apellidos }}</td>
                   <td class="px-6 py-4">{{ $quincena->rut }}</td>
                   <td class="px-6 py-4 text-green-600 font-medium">${{ number_format($quincena->monto, 2) }}</td>
                   <td class="px-6 py-4">{{ date('F Y', strtotime($quincena->mes)) }}</td>
               </tr>
               @endforeach
           </tbody>
       </table>
   </div>
</div>
@endsection
