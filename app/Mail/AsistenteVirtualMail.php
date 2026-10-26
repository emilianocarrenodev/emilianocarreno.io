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
            subject: 'Full Stack Developer & Salesforce',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.asistente-virtual',
            text: 'emails.asistente-virtual-texto',
        );
    }
}
