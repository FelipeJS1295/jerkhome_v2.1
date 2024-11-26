<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores'; // Nombre de la tabla
    protected $fillable = [
        'id',
        'users_id',
        'nombres',
        'apellidos',
        'rut',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'afp',
        'salud',
        'sueldo',
        'fecha_ingreso',
        'talla_polera',
        'talla_zapatos',
        'talla_pantalon',
    ];

    /**
     * Relación con la tabla `users`
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relación con la tabla `produccion`
     */
    public function producciones()
    {
        return $this->hasMany(Produccion::class, 'trabajadores_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
