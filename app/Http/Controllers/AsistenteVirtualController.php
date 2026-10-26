<?php

namespace App\Http\Controllers;

use App\Mail\AsistenteVirtualMail;
use App\Models\AsistenteVirtualEmail;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
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
        $this->createEmailSendsTableIfMissing();

        $delivery = AsistenteVirtualEmail::firstOrCreate(['email' => $email]);

        if (! $delivery->wasRecentlyCreated) {
            return response()->json([
                'message' => 'Ya se envió un email a esta dirección.',
            ], 409);
        }

        try {
            Mail::to($email)->send(new AsistenteVirtualMail);
        } catch (Throwable $exception) {
            $delivery->delete();

            throw $exception;
        }

        return response()->json([
            'message' => 'Email enviado correctamente.',
        ], 201);
    }

    private function createEmailSendsTableIfMissing(): void
    {
        if (Schema::hasTable('asistente_virtual_email_sends')) {
            return;
        }

        Schema::create('asistente_virtual_email_sends', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
}
