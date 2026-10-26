<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AsistenteVirtualMail extends Mailable
{
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mensaje del asistente virtual',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.asistente-virtual',
        );
    }
}
