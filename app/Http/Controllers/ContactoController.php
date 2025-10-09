<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email',
            'mensaje' => 'required|string',
        ]);

        // Aquí podrías enviar un correo o guardar en DB
        // Mail::to('tu-correo@dominio.com')->send(new ContactFormMail($request));

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
