<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    protected $table = 'reservaciones';

    protected $fillable = [
        'cliente_id',
        'vuelo_id',
        'asientos',
    ];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con vuelo
    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class);
    }
}
