@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Orden de Trabajo</h1>

    <form action="{{ route('produccion.update', $produccion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="trabajadores_id">Trabajador</label>
            <select name="trabajadores_id" id="trabajadores_id" class="form-control" required>
                @foreach ($trabajadores as $trabajador)
                    <option value="{{ $trabajador->id }}" {{ $trabajador->id == $produccion->trabajadores_id ? 'selected' : '' }}>
                        {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="productos_id">Producto</label>
            <select name="productos_id" id="productos_id" class="form-control" required>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $producto->id == $produccion->productos_id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $produccion->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="numero_orden_trabajo">Número de Orden de Trabajo</label>
            <input type="text" name="numero_orden_trabajo" id="numero_orden_trabajo" class="form-control" value="{{ $produccion->numero_orden_trabajo }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
