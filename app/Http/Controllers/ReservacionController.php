<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // <-- ¡IMPORTANTE! Añade esta línea

class ReservacionController extends Controller
{
    /**
     * Muestra las reservaciones del cliente autenticado.
     */
    public function index()
    {
        $reservaciones = Reservacion::where('cliente_id', Auth::id())
            ->with('vuelo', 'cliente') // Carga también el cliente para el boleto
            ->latest()
            ->get();

        return view('reservaciones.index', compact('reservaciones'));
    }

    /**
     * Muestra los detalles de una reservación específica (para el modal).
     * Retorna los datos en formato JSON para ser usados por JavaScript.
     */
    public function show(Reservacion $reservacion)
    {
        // Política de seguridad: Asegurarse de que el usuario solo pueda ver sus propias reservaciones
        if ($reservacion->cliente_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Cargar la relación con el vuelo para tener acceso a sus datos
        $reservacion->load('vuelo');

        // Retornar los datos como JSON
        return response()->json($reservacion);
    }

    /**
     * Genera y muestra el boleto de una reservación en formato PDF.
     */
    public function generarBoletoPDF(Reservacion $reservacion)
    {
        // Política de seguridad
        if ($reservacion->cliente_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        // Cargar las relaciones necesarias
        $reservacion->load('vuelo', 'cliente');

        // Cargar la vista del boleto y pasarle los datos
        $pdf = Pdf::loadView('reservaciones.boleto_pdf', compact('reservacion'));
        
        // Define un nombre de archivo para el PDF
        $fileName = 'boleto-skywings-' . $reservacion->id . '.pdf';

        // Muestra el PDF en el navegador en lugar de descargarlo directamente
        return $pdf->stream($fileName);
    }

    /**
     * Muestra el formulario para crear una nueva reservación.
     */
    public function create($vuelo_id)
    {
        $vuelo = Vuelo::findOrFail($vuelo_id);
        $asientosOcupados = Reservacion::where('vuelo_id', $vuelo->id)
            ->pluck('numeros_asiento')
            ->flatten()
            ->toArray();
        return view('reservaciones.create', compact('vuelo', 'asientosOcupados'));
    }

    /**
     * Guarda la nueva reservación en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vuelo_id' => 'required|exists:vuelos,id',
            'asientos_seleccionados' => 'required|string|min:1',
            'metodo_pago' => 'required|in:tarjeta,paypal',
            'paypal_email' => 'required_if:metodo_pago,paypal|email',
        ], [
            'asientos_seleccionados.required' => 'Debes seleccionar al menos un asiento.',
        ]);

        $vuelo = Vuelo::findOrFail($request->vuelo_id);
        $asientosSeleccionados = explode(',', $request->asientos_seleccionados);
        $cantidadAsientos = count($asientosSeleccionados);

        try {
            DB::beginTransaction();

            $asientosYaOcupados = Reservacion::where('vuelo_id', $vuelo->id)
                ->lockForUpdate()
                ->pluck('numeros_asiento')->flatten()->all();

            $conflicto = array_intersect($asientosSeleccionados, $asientosYaOcupados);

            if (!empty($conflicto)) {
                return back()->withErrors(['asientos_seleccionados' => 'Lo sentimos, el asiento ' . $conflicto[0] . ' acaba de ser ocupado. Por favor, elige otro.'])->withInput();
            }

            Reservacion::create([
                'cliente_id'      => Auth::id(),
                'vuelo_id'        => $request->vuelo_id,
                'numeros_asiento' => $asientosSeleccionados,
                'asientos'        => $cantidadAsientos,
                'metodo_pago'     => $request->metodo_pago,
                'paypal_email'    => $request->metodo_pago === 'paypal' ? $request->paypal_email : null,
                'fecha_reserva'   => now(),
            ]);

            $vuelo->asientos_disponibles -= $cantidadAsientos;
            $vuelo->asientos_ocupados += $cantidadAsientos;
            $vuelo->save();
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error inesperado al procesar tu reservación.'])->withInput();
        }

        return redirect()
            ->route('reservaciones.index')
            ->with('success', '¡Reservación creada exitosamente!');
    }
}
