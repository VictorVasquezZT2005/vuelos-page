<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    protected $table = 'vuelos';

    protected $fillable = [
        'origen',
        'destino',
        'fecha',
        'hora',
        'precio',
    ];

    // Relación con reservaciones
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }
}
