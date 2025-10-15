<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    protected $table = 'vuelos';

protected $fillable = [
    'codigo',
    'origen',
    'destino',
    'fecha_salida',
    'fecha_llegada',
    'precio',
    'asientos_disponibles',
    'asientos_ocupados',
];


    // Relación con reservaciones
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }
}
