<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion'; // Nombre de la tabla
    protected $fillable = [
        'trabajadores_id',
        'productos_id',
        'fecha',
        'numero_orden_trabajo',
        'descripcion',
        'precio_reparacion',
        'tipo',
    ];

    /**
     * Relación con la tabla `trabajadores`
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajadores_id');
    }

    /**
     * Relación con la tabla `productos`
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id');
    }
}
