<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\Vuelo;
use Illuminate\Support\Facades\Auth;

class ReservacionController extends Controller
{
    public function index()
    {
        $reservaciones = Reservacion::where('cliente_id', Auth::id())
            ->with('vuelo')
            ->get();

        return view('reservaciones.index', compact('reservaciones'));
    }

    public function create($vuelo_id)
    {
        $vuelo = Vuelo::findOrFail($vuelo_id);
        return view('reservaciones.create', compact('vuelo'));
    }

    public function store(Request $request)
    {
        // Validación de campos, pero no se guardan los datos de tarjeta
        $request->validate([
            'vuelo_id' => 'required|exists:vuelos,id',
            'asientos' => 'required|integer|min:1',
            'metodo_pago' => 'required|in:tarjeta,paypal',
            'paypal_email' => 'required_if:metodo_pago,paypal|email',
            // numero_tarjeta, expiracion y cvv solo se usan en frontend para procesar pago
        ]);

        // Crear reservación sin guardar datos de tarjeta
        Reservacion::create([
            'cliente_id'   => Auth::id(),
            'vuelo_id'     => $request->vuelo_id,
            'asientos'     => $request->asientos,
            'metodo_pago'  => $request->metodo_pago,
            'paypal_email' => $request->metodo_pago === 'paypal' ? $request->paypal_email : null,
            // fecha_reserva se llenará automáticamente en el modelo si está definido
        ]);

        return redirect()
            ->route('reservaciones.index')
            ->with('success', 'Reservación creada exitosamente.');
    }
}
