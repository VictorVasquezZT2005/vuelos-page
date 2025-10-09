<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relación con reservaciones
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'cliente_id');
    }
}
