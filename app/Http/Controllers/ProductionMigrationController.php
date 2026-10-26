<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class ProductionMigrationController extends Controller
{
    public function confirm(string $code): Response
    {
        $expectedCode = (string) config('services.validate_url.code');

        if ($expectedCode === '' || ! hash_equals($expectedCode, $code)) {
            return response('', Response::HTTP_OK);
        }

        return response()->view('maintenance.migrations', ['code' => $code]);
    }

    public function run(string $code): Response
    {
        $expectedCode = (string) config('services.validate_url.code');

        if ($expectedCode === '' || ! hash_equals($expectedCode, $code)) {
            return response('', Response::HTTP_OK);
        }

        $exitCode = Artisan::call('migrate', [
            '--force' => true,
            '--no-interaction' => true,
        ]);

        return response()->view('maintenance.migrations', [
            'exitCode' => $exitCode,
            'output' => Artisan::output(),
            'code' => $code,
        ], $exitCode === 0 ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
