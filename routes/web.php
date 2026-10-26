<?php

use App\Http\Controllers\AsistenteVirtualController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/asistente-virtual', [AsistenteVirtualController::class, 'sendEmail'])
    ->name('asistente-virtual');
