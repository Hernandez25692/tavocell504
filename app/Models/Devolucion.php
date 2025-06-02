<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'factura_id',
        'usuario_id',
        'motivo',
        'total',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleDevolucion::class);
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
