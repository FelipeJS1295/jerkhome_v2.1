<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos'; // Nombre de la tabla
    protected $fillable = [
        'sku',
        'sku_esqueleto',
        'sku_hites',
        'sku_la_polar',
        'nombre',
        'esqueleto',
        'imagen_corte',
        'imagen_tapizado',
        'imagen_corte_esqueleto',
        'imagen_esqueleto',
        'costo_costura',
        'costo_tapiceria',
        'costo_esqueleteria',
        'costo_armado',
        'costo_corte',
    ];

    /**
     * Relación con insumos
     */
    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'producto_insumo', 'producto_id', 'insumo_id')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    /**
     * Relación con la tabla `produccion`
     */
    public function producciones()
    {
        return $this->hasMany(Produccion::class, 'productos_id');
    }
}
