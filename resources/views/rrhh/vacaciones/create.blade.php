@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
   <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:max-w-2xl">
       <div class="md:flex">
           <div class="p-8 w-full">
               <h1 class="text-2xl font-bold text-center text-gray-900 mb-8">Registrar Vacaciones</h1>
               
               <form action="{{ route('rrhh.vacaciones.store') }}" method="POST" class="space-y-6">
                   @csrf

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Trabajador</label>
                       <select name="trabajador_id" required class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                           <option value="">Seleccione un trabajador</option>
                           @foreach($trabajadores as $trabajador)
                           <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</option>
                           @endforeach
                       </select>
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Fecha Desde</label>
                       <input type="date" name="fecha_desde" required 
                           class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Fecha Hasta</label>
                       <input type="date" name="fecha_hasta" required
                           class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Estado</label>
                       <select name="estado" required
                           class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                           <option value="autorizado">Autorizado</option>
                           <option value="no autorizado">No Autorizado</option>
                       </select>
                   </div>

                   <button type="submit" 
                       class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                       Registrar Vacaciones
                   </button>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection