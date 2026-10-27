<?php

namespace App\Http\Controllers;

use App\Models\EmailOpenTracking;
use Symfony\Component\HttpFoundation\Response;

class EmailOpenController extends Controller
{
    public function __invoke(string $token): Response
    {
        EmailOpenTracking::query()
            ->where('tracking_token', $token)
            ->whereNull('opened_at')
            ->update(['opened_at' => now()]);

        return response(
            "GIF89a\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\xff\xff\xff!\xf9\x04\x01\x00\x00\x00\x00,\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02D\x01\x00;",
            Response::HTTP_OK,
            [
                'Cache-Control' => 'no-store, private, max-age=0',
                'Content-Type' => 'image/gif',
                'Expires' => '0',
                'Pragma' => 'no-cache',
                'X-Content-Type-Options' => 'nosniff',
            ],
        );
    }
}
