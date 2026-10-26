<?php

namespace App\Http\Controllers;

use App\Mail\AsistenteVirtualMail;
use App\Models\SentEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AsistenteVirtualController extends Controller
{
    public function sendEmail(string $code, string $email): Response
    {
        $expectedCode = (string) config('services.asistente_virtual.code');

        if ($expectedCode === '' || ! hash_equals($expectedCode, $code)) {
            return response('', Response::HTTP_OK);
        }

        Validator::make(['email' => $email], [
            'email' => ['required', 'email', 'max:255'],
        ])->validate();

        $email = mb_strtolower($email);

        $delivery = SentEmail::firstOrCreate(['email' => $email]);

        if (! $delivery->wasRecentlyCreated) {
            return response()->json([
                'message' => 'Ya se envió un email a esta dirección.',
            ], Response::HTTP_CONFLICT);
        }

        try {
            Mail::to($email)->send(new AsistenteVirtualMail);
        } catch (Throwable $exception) {
            $delivery->delete();

            throw $exception;
        }

        return response()->json([
            'message' => 'Email enviado correctamente.',
        ], Response::HTTP_CREATED);
    }
}
