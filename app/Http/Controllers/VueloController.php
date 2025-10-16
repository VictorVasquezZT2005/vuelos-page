<?php

namespace App\Http\Controllers;

use App\Models\Vuelo;
use Carbon\Carbon; // <-- 1. Importa la clase Carbon

class VueloController extends Controller
{
    public function index()
    {
        // 2. Obtiene la fecha y hora actual en la zona horaria de El Salvador
        $nowInElSalvador = Carbon::now('America/El_Salvador');

        // 3. Filtra los vuelos para obtener solo los futuros y con asientos
        $vuelos = Vuelo::where('fecha_salida', '>', $nowInElSalvador)
                       ->where('asientos_disponibles', '>', 0)
                       ->orderBy('fecha_salida', 'asc') // Opcional: ordena los vuelos por fecha
                       ->get();

        return view('vuelos.index', compact('vuelos'));
    }
}