<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMailable;
use Illuminate\Support\Facades\Validator;

class ContactoController extends Controller
{
    /**
     * Maneja el envío del formulario de contacto.
     */
    public function send(Request $request)
    {
        // 1. Validar los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // 2. Enviar el correo
        try {
            // =======================================================
            // ========= CAMBIO REALIZADO AQUÍ =======================
            // =======================================================
            $correoDestino = "vvasquezdv2016@gmail.com"; 
            
            Mail::to($correoDestino)->send(new ContactoMailable($request->all()));

        } catch (\Exception $e) {
            // Manejar error de envío
            // Opcional: Registrar el error para depuración
            // \Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
            return back()
                    ->with('error', 'Hubo un problema al enviar el mensaje. Inténtalo más tarde.')
                    ->withInput();
        }

        // 3. Redirigir con mensaje de éxito
        return back()->with('success', '¡Mensaje enviado con éxito! Te responderemos pronto.');
    }
}
