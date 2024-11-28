@extends('layouts.app')

@section('content')
<div class="prestamos-form">
    <h1>Aplazar Cuota</h1>
    <form action="{{ route('rrhh.prestamos.aplazar_cuota', $prestamo->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="trabajador">Trabajador</label>
            <input type="text" id="trabajador" value="{{ $prestamo->nombres }} {{ $prestamo->apellidos }}" readonly>
        </div>

        <div class="form-group">
            <label for="monto">Monto de la Cuota</label>
            <input type="text" id="monto" value="${{ number_format($cuota->monto_cuota, 2) }}" readonly>
        </div>

        <div class="form-group">
            <label for="mes">Mes de la Cuota Actual</label>
            <input type="text" id="mes" value="{{ date('F Y', strtotime($cuota->mes)) }}" readonly>
        </div>

        <p>¿Estás seguro de que deseas aplazar esta cuota al próximo mes?</p>

        <button type="submit" class="btn-submit">Aplazar Cuota</button>
    </form>
</div>
@endsection
