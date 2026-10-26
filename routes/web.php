<?php

use App\Http\Controllers\AsistenteVirtualController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asistente-virtual/{code}/{email}', [AsistenteVirtualController::class, 'sendEmail'])
    ->name('asistente-virtual');
