<?php

use App\Http\Controllers\ProductionMigrationController;
use Illuminate\Support\Facades\Route;

Route::get('/maintenance/migrations/{code}', [ProductionMigrationController::class, 'confirm'])
    ->name('maintenance.migrations.confirm');

Route::post('/maintenance/migrations/{code}', [ProductionMigrationController::class, 'run'])
    ->name('maintenance.migrations.run');
