@extends('layouts.app')

@section('content')
<div class="workers-dashboard">
    <div class="dashboard-header">
        <div class="title-section">
            <h1>Trabajadores</h1>
            <span class="worker-count">Total: {{ $trabajadores->count() }}</span>
        </div>
        <a href="{{ route('rrhh.trabajadores.create') }}" class="btn-add">
            <i class="fas fa-user-plus"></i> Agregar Trabajador
        </a>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="table-container">
        <table class="workers-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>RUT</th>
                    <th>Teléfono</th>
                    <th class="actions-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trabajadores as $trabajador)
                <tr>
                    <td class="font-medium">{{ $trabajador->nombres }}</td>
                    <td>{{ $trabajador->apellidos }}</td>
                    <td class="rut">{{ $trabajador->rut }}</td>
                    <td>{{ $trabajador->telefono }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('rrhh.trabajadores.edit', $trabajador->id) }}" class="btn-edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('rrhh.trabajadores.destroy', $trabajador->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete" onclick="confirmDelete(this)" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <div class="empty-content">
                            <i class="fas fa-users"></i>
                            <p>No hay trabajadores registrados</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(button) {
    if (confirm('¿Está seguro de eliminar este trabajador?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection
