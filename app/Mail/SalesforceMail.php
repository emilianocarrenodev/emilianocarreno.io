<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SalesforceMail extends Mailable
{
    public function __construct(public ?string $trackingToken = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Full Stack Developer & Salesforce',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.salesforce',
            text: 'emails.salesforce-texto',
        );
    }
}
