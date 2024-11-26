<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    // Página principal de Configuración
    public function index()
    {
        return view('configuracion.index');
    }


    // Gestión de Clientes
    public function clientes()
    {
        return view('configuracion.clientes.index');
    }

    // Gestión de Proveedores
    public function proveedores()
    {
        return view('configuracion.proveedores.index');
    }

    // Gestión de Insumos
    public function insumos()
    {
        return view('configuracion.insumos.index');
    }

}
