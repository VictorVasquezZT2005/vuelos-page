<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    use HasFactory;

    protected $table = 'reservaciones';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'vuelo_id',
        'numeros_asiento', // <-- AÑADIDO: Para guardar los asientos específicos
        'asientos',        // Mantenemos la cantidad total por conveniencia
        'fecha_reserva',
        'metodo_pago',
        'paypal_email',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'numeros_asiento' => 'array', // <-- AÑADIDO: Laravel convierte JSON <-> Array automáticamente
        'fecha_reserva' => 'datetime',
    ];

    /**
     * Relación con el modelo Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con el modelo Vuelo.
     */
    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class);
    }
}