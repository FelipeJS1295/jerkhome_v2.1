<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    protected $fillable = [
        'sku_padre',
        'sku_hijo',
        'nombre',
        'unidad_medida',
        'proveedor_id',
        'precio_costo',
        'precio_venta'
    ];

    public $timestamps = true;

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_insumo')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
