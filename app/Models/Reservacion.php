<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservacion extends Model
{
    use HasFactory;

    protected $table = 'reservaciones';

    // Solo los campos que realmente se guardan en la DB
    protected $fillable = [
        'cliente_id',
        'vuelo_id',
        'asientos',
        'fecha_reserva',
        'metodo_pago',
        'paypal_email',
    ];

    protected $dates = [
        'fecha_reserva',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class);
    }

    protected static function booted()
    {
        static::creating(function ($reservacion) {
            if (!$reservacion->fecha_reserva) {
                $reservacion->fecha_reserva = now();
            }
        });
    }
}
