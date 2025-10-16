<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address; // Importante: Añadir Address

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    // Propiedad pública para guardar los datos del formulario
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        // Guarda los datos del formulario (nombre, correo, mensaje)
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Define quién envía el correo y a quién responder
            from: new Address('no-reply@tusvuelos.com', 'Tu App de Vuelos'),
            replyTo: [
                new Address($this->data['correo'], $this->data['nombre'])
            ],
            // Este es el asunto del correo que TÚ recibirás
            subject: 'Nuevo Mensaje de Contacto - Vuelos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Define la vista que se usará como cuerpo del correo
        return new Content(
            view: 'emails.contacto',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}