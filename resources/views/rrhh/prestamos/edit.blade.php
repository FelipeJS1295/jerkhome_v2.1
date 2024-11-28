@extends('layouts.app')

@section('content')
<div class="prestamos-form">
    <h1>Editar Préstamo</h1>
    <form action="{{ route('rrhh.prestamos.update', $prestamo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="trabajador_id">Trabajador</label>
            <select name="trabajador_id" id="trabajador_id" required>
                @foreach($trabajadores as $trabajador)
                <option value="{{ $trabajador->id }}" {{ $trabajador->id == $prestamo->trabajador_id ? 'selected' : '' }}>
                    {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="monto">Monto del Préstamo</label>
            <input type="number" name="monto" id="monto" step="0.01" value="{{ $prestamo->monto }}" required>
        </div>

        <div class="form-group">
            <label for="cuotas">Número de Cuotas</label>
            <input type="number" name="cuotas" id="cuotas" value="{{ $prestamo->cuotas }}" required>
        </div>

        <div class="form-group">
            <label for="mes_inicio">Mes de Inicio</label>
            <input type="month" name="mes_inicio" id="mes_inicio" value="{{ date('Y-m', strtotime($prestamo->mes_inicio)) }}" required>
        </div>

        <button type="submit" class="btn-submit">Actualizar</button>
    </form>
</div>
@endsection
