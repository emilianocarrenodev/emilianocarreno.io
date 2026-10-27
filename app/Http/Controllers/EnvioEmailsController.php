<?php

namespace App\Http\Controllers;

use App\Mail\AsistenteVirtualMail;
use App\Mail\SalesforceMail;
use App\Mail\WordPressMail;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EnvioEmailsController extends Controller
{
    private const EMAIL_TYPES = [
        'asistente-virtual' => 'Asistente virtual',
        'salesforce' => 'Salesforce',
        'wordpress' => 'WordPress',
    ];

    public function create(string $code): Response
    {
        if (! $this->hasValidAccessCode($code)) {
            return response('', Response::HTTP_OK);
        }

        return response()->view('envio-emails', [
            'code' => $code,
            'emailTypes' => self::EMAIL_TYPES,
        ]);
    }

    public function sendEmail(string $code, Request $request): Response
    {
        if (! $this->hasValidAccessCode($code)) {
            return response('', Response::HTTP_OK);
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'email_type' => ['required', Rule::in(array_keys(self::EMAIL_TYPES))],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede superar los 255 caracteres.',
            'email_type.required' => 'Selecciona el tipo de email que deseas enviar.',
            'email_type.in' => 'Selecciona un tipo de email válido.',
        ]);

        $email = mb_strtolower($validated['email']);
        $emailType = $validated['email_type'];
        $delivery = SentEmail::firstOrCreate(['email' => $email]);

        /*if (! $delivery->wasRecentlyCreated) {
            return to_route('envio-emails', ['code' => $code])
                ->with('error', 'Ya se envió un email a esta dirección.');
        }*/

        $tracking = $delivery->recordOpenTracking($emailType);
        $mail = $this->makeMail($emailType, $tracking->tracking_token);

        try {
            Mail::to($email)->send($mail);
        } catch (Throwable $exception) {
            $tracking->delete();

            if ($delivery->wasRecentlyCreated) {
                $delivery->delete();
            }

            throw $exception;
        }

        return to_route('envio-emails', ['code' => $code])
            ->with('status', 'El email de tipo '.self::EMAIL_TYPES[$emailType].' se envió correctamente.');
    }

    private function hasValidAccessCode(string $code): bool
    {
        $expectedCode = (string) config('services.validate_url.code');

        return $expectedCode !== '' && hash_equals($expectedCode, $code);
    }

    private function makeMail(string $emailType, string $trackingToken): Mailable
    {
        return match ($emailType) {
            'asistente-virtual' => new AsistenteVirtualMail($trackingToken),
            'salesforce' => new SalesforceMail($trackingToken),
            'wordpress' => new WordPressMail($trackingToken),
        };
    }
}
