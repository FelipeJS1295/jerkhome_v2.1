<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Definir la tabla asociada (opcional si el nombre es el mismo que el modelo en plural)
    protected $table = 'ventas';

    // Permitir la asignación masiva de los siguientes campos
    protected $fillable = [
        'cliente_id',
        'numero_orden',
        'cliente_final',
        'rut_documento',
        'email',
        'telefono',
        'fecha_compra',
        'fecha_entrega',
        'fecha_cliente',
        'producto',
        'precio',
        'precio_cliente',
        'costo_despacho',
        'comuna',
        'direccion',
        'region',
        'sku',
        'estado',
        'documento',
        'razon_social',
        'rut',
        'giro',
        'direccion_factura',
        'currier',
    ];

    // Definir los campos que serán tratados como fechas
    protected $dates = [
        'fecha_compra',
        'fecha_entrega',
        'fecha_cliente',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
