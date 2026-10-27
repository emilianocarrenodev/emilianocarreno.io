<?php

use App\Http\Controllers\EmailOpenController;
use App\Http\Controllers\EnvioEmailsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/open/{token}', EmailOpenController::class)
    ->name('email.open');

Route::get('/envio-emails/{code}', [EnvioEmailsController::class, 'create'])
    ->name('envio-emails');

Route::post('/envio-emails/{code}', [EnvioEmailsController::class, 'sendEmail'])
    ->name('envio-emails.send');
