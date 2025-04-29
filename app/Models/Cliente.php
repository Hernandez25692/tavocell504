<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'identidad',
        'telefono',
        'correo',
        'direccion',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }
}
