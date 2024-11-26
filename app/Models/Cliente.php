<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'rut',
        'nombre',
        'tipo',
    ];

    public $timestamps = true;

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}
