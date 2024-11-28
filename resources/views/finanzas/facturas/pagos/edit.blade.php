@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Pago</h1>

    <form action="{{ route('finanzas.facturas.pagos.actualizar', $pago->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="tipo_pago" class="block text-gray-700 font-bold mb-2">Tipo de Pago</label>
            <select name="tipo_pago" id="tipo_pago" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                <option value="cheque" {{ $pago->tipo_pago == 'cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="transferencia" {{ $pago->tipo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                <option value="cuota" {{ $pago->tipo_pago == 'cuota' ? 'selected' : '' }}>Cuota</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="monto" class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" id="monto" value="{{ $pago->monto }}" step="0.01"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="fecha_pago" class="block text-gray-700 font-bold mb-2">Fecha del Pago</label>
            <input type="date" name="fecha_pago" id="fecha_pago" value="{{ $pago->fecha_pago }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="detalles" class="block text-gray-700 font-bold mb-2">Detalles (opcional)</label>
            <textarea name="detalles" id="detalles" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">{{ $pago->detalles }}</textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600">
                Actualizar Pago
            </button>
        </div>
    </form>
</div>
@endsection
