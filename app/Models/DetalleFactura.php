<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_unitario',
        'precio_compra_unitario',
        'subtotal',
        'descripcion',
    ];

    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class);
    }

    public function factura()
    {
        return $this->belongsTo(\App\Models\Factura::class);
    }
}
