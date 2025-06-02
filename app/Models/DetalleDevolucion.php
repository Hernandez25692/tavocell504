<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDevolucion extends Model
{
    use HasFactory;

    protected $table = 'detalle_devoluciones';

    protected $fillable = [
        'devolucion_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function devolucion()
    {
        return $this->belongsTo(Devolucion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
