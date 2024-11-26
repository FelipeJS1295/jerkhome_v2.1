@extends('layouts.app')

@section('content')
<div class="config-dashboard">
    <header class="dashboard-header">
        <h1>Configuración del Sistema</h1>
        <p>Gestione todos los aspectos de su plataforma</p>
    </header>

    <div class="menu-grid">
        <!-- Usuarios -->
        <div class="menu-item">
            <div class="icon-wrapper users">
                <i class="fas fa-users"></i>
            </div>
            <div class="content">
                <h2>Usuarios</h2>
                <p>Gestión de usuarios y permisos</p>
                <div class="actions">
                    <a href="{{ route('usuarios.index') }}" class="btn-view">Ver Listado</a>
                    <a href="{{ route('usuarios.create') }}" class="btn-create">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="menu-item">
            <div class="icon-wrapper clients">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="content">
                <h2>Clientes</h2>
                <p>Administración de clientes</p>
                <div class="actions">
                    <a href="{{ route('configuracion.clientes.index') }}" class="btn-view">Ver Listado</a>
                    <a href="{{ route('configuracion.clientes.create') }}" class="btn-create">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Proveedores -->
        <div class="menu-item">
            <div class="icon-wrapper suppliers">
                <i class="fas fa-truck-field"></i>
            </div>
            <div class="content">
                <h2>Proveedores</h2>
                <p>Control de proveedores</p>
                <div class="actions">
                    <a href="{{ route('configuracion.proveedores.index') }}" class="btn-view">Ver Listado</a>
                    <a href="{{ route('configuracion.proveedores.create') }}" class="btn-create">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Insumos -->
        <div class="menu-item">
            <div class="icon-wrapper supplies">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <div class="content">
                <h2>Insumos</h2>
                <p>Gestión de insumos y materiales</p>
                <div class="actions">
                    <a href="{{ route('insumos.index') }}" class="btn-view">Ver Listado</a>
                    <a href="{{ route('insumos.create') }}" class="btn-create">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="menu-item">
            <div class="icon-wrapper products">
                <i class="fas fa-box"></i>
            </div>
            <div class="content">
                <h2>Productos</h2>
                <p>Catálogo de productos</p>
                <div class="actions">
                    <a href="{{ route('productos.index') }}" class="btn-view">Ver Listado</a>
                    <a href="{{ route('productos.create') }}" class="btn-create">Nuevo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection