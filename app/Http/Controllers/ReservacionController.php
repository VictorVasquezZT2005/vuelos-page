<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservacionController extends Controller
{
    /**
     * Muestra las reservaciones del cliente autenticado.
     */
    public function index()
    {
        $reservaciones = Reservacion::where('cliente_id', Auth::id())
            ->with('vuelo', 'cliente')
            ->latest()
            ->get();

        return view('reservaciones.index', compact('reservaciones'));
    }

    /**
     * Muestra los detalles de una reservación específica (para el modal).
     */
    public function show(Reservacion $reservacion)
    {
        // Política de seguridad
        if ($reservacion->cliente_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $reservacion->load('vuelo');
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

        $reservacion->load('vuelo', 'cliente');
        $pdf = Pdf::loadView('reservaciones.boleto_pdf', compact('reservacion'));
        
        // Define un tamaño de papel personalizado para que coincida con el boleto.
        $pdf->setPaper([0, 0, 600, 310]);
        
        $fileName = 'boleto-skywings-' . $reservacion->id . '.pdf';
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
            
            // ===================================================================
            // ===== INICIO DE LA LÍNEA MODIFICADA ===============================
            // ===================================================================

            // Se agrega 'nullable' para permitir que el campo esté vacío o no exista
            // si el método de pago no es 'paypal'.
            'paypal_email' => 'nullable|required_if:metodo_pago,paypal|email',

            // ===================================================================
            // ===== FIN DE LA LÍNEA MODIFICADA ==================================
            // ===================================================================
        ], [
            'asientos_seleccionados.required' => 'Debes seleccionar al menos un asiento.',
            'paypal_email.required_if' => 'El correo de PayPal es obligatorio cuando se elige ese método de pago.',
        ]);

        $vuelo = Vuelo::findOrFail($request->vuelo_id);
        $asientosSeleccionados = explode(',', $request->asientos_seleccionados);
        $cantidadAsientos = count($asientosSeleccionados);

        try {
            DB::beginTransaction();

            // Bloquea la tabla para evitar que dos personas reserven el mismo asiento a la vez
            $asientosYaOcupados = Reservacion::where('vuelo_id', $vuelo->id)
                ->lockForUpdate()
                ->pluck('numeros_asiento')->flatten()->all();

            $conflicto = array_intersect($asientosSeleccionados, $asientosYaOcupados);

            if (!empty($conflicto)) {
                DB::rollBack();
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
            // Para depuración, puedes registrar el error: \Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error inesperado al procesar tu reservación.'])->withInput();
        }

        return redirect()
            ->route('reservaciones.index')
            ->with('success', '¡Reservación creada exitosamente!');
    }
}
