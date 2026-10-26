<?php

namespace App\Http\Controllers;

use App\Mail\AsistenteVirtualMail;
use App\Models\AsistenteVirtualEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AsistenteVirtualController extends Controller
{
    public function sendEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = mb_strtolower($validated['email']);
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
}
