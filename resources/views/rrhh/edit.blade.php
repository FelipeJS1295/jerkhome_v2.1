@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($trabajador) ? 'Editar Trabajador' : 'Agregar Trabajador' }}</h1>
    <form action="{{ isset($trabajador) ? route('rrhh.update', $trabajador->id) : route('rrhh.store') }}" method="POST">
        @csrf
        @if(isset($trabajador))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" value="{{ $trabajador->user_id ?? old('user_id') }}" required>
        </div>
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control" value="{{ $trabajador->nombres ?? old('nombres') }}" required>
        </div>
        <!-- Continúa con todos los demás campos -->
        <button type="submit" class="btn btn-success mt-3">{{ isset($trabajador) ? 'Actualizar' : 'Guardar' }}</button>
    </form>
</div>
@endsection
