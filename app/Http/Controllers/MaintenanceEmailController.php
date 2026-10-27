<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceEmailController extends Controller
{
    public function index(string $code): Response
    {
        $expectedCode = (string) config('services.validate_url.code');

        if ($expectedCode === '' || ! hash_equals($expectedCode, $code)) {
            return response('', Response::HTTP_OK);
        }

        $sentEmails = DB::table('sent_emails')
            ->leftJoin('email_open_trackings', 'sent_emails.id', '=', 'email_open_trackings.sent_email_id')
            ->select([
                'sent_emails.id',
                'sent_emails.email',
                'sent_emails.created_at',
                'sent_emails.updated_at',
                'email_open_trackings.channel',
                'email_open_trackings.opened_at',
            ])
            ->orderByDesc('sent_emails.id')
            ->paginate(50);

        return response()->view('maintenance.emails', ['sentEmails' => $sentEmails]);
    }
}
