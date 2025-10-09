<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class ReservacionController extends Controller
{
    /**
     * Mostrar las reservaciones del cliente autenticado
     */
    public function index()
    {
        /** @var Cliente $cliente */
        $cliente = Auth::user(); // Obtenemos el cliente autenticado

        // Si por algún motivo no hay cliente autenticado, redirigimos
        if (!$cliente) {
            return redirect()->route('login')->with('error', 'Por favor inicia sesión.');
        }

        // Obtenemos las reservaciones con el vuelo asociado
        $reservaciones = $cliente->reservaciones()->with('vuelo')->get();

        return view('reservaciones.index', compact('reservaciones'));
    }
}
