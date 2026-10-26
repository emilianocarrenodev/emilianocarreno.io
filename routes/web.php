<?php

use App\Http\Controllers\AsistenteVirtualController;
use App\Http\Controllers\SalesforceController;
use App\Http\Controllers\WordPressController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asistente-virtual/{code}/{email}', [AsistenteVirtualController::class, 'sendEmail'])
    ->name('asistente-virtual');

Route::get('/salesforce/{code}/{email}', [SalesforceController::class, 'sendEmail'])
    ->name('salesforce');

Route::get('/wordpress/{code}/{email}', [WordPressController::class, 'sendEmail'])
    ->name('wordpress');
