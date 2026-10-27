<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class WordPressMail extends Mailable
{
    public function __construct(public ?string $trackingToken = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Desarrollo WordPress',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.wordpress',
            text: 'emails.wordpress-texto',
        );
    }
}
