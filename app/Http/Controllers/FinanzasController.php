<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanzasController extends Controller
{
    /**
     * Muestra el panel principal de Finanzas.
     */
    public function index()
    {
        return view('finanzas.index');
    }

    /**
     * Muestra la sección de Créditos.
     */
    public function creditos()
    {
        return view('finanzas.creditos.index');
    }

    /**
     * Muestra la sección de Facturas de Compras.
     */
    public function facturas()
    {
        return view('finanzas.facturas.index');
    }

    /**
     * Muestra la sección de Boletas Extras.
     */
    public function boletas()
    {
        return view('finanzas.boletas.index');
    }

    /**
     * Muestra la sección de Gastos Extras.
     */
    public function gastos()
    {
        return view('finanzas.gastos.index');
    }

    /**
     * Muestra la sección de IVA.
     */
    public function iva()
    {
        return view('finanzas.iva.index');
    }
}
