<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalidaCaja extends Model
{
    protected $table = 'salidas_caja';

    protected $fillable = [
        'usuario_id',
        'monto',
        'motivo',
        'comprobante',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
