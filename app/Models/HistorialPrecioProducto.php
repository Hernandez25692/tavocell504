<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPrecioProducto extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'precio_compra',
        'precio_venta',
        'fecha_registro',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
