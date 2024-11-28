@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
   <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:max-w-2xl">
       <div class="md:flex">
           <div class="p-8 w-full">
               <h1 class="text-2xl font-bold text-center text-gray-900 mb-8">Registrar Bono</h1>
               
               <form action="{{ route('rrhh.bonos.store') }}" method="POST" class="space-y-6">
                   @csrf

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Trabajador</label>
                       <select name="trabajador_id" required class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-pink-600 focus:border-transparent">
                           <option value="">Seleccione un trabajador</option>
                           @foreach($trabajadores as $trabajador)
                           <option value="{{ $trabajador->id }}">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</option>
                           @endforeach
                       </select>
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Monto del Bono</label>
                       <div class="mt-2 relative rounded-lg shadow-sm">
                           <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                               <span class="text-gray-500 sm:text-sm">$</span>
                           </div>
                           <input type="number" name="monto" step="0.01" min="0" required
                               class="block w-full pl-7 rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-pink-600 focus:border-transparent">
                       </div>
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Mes</label>
                       <input type="month" name="mes" required
                           class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-pink-600 focus:border-transparent">
                   </div>

                   <div>
                       <label class="block text-sm font-semibold text-gray-700">Comentario</label>
                       <textarea name="comentario" rows="3" 
                           class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-900 focus:ring-2 focus:ring-pink-600 focus:border-transparent"></textarea>
                   </div>

                   <button type="submit" 
                       class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-150 ease-in-out">
                       Registrar Bono
                   </button>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection