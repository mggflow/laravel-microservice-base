<?php

use Illuminate\Support\Facades\Route;
use MGGFLOW\ExceptionManager\ManageException;

Route::prefix('monitoring')->group(function () {
    Route::any('ping', [\App\Http\Controllers\MonitoringController::class, 'ping']);
});

Route::any('greeting', [\App\Http\Controllers\GreetingsController::class, 'hello']);

/**
 * API 404 handling.
 */
Route::fallback(function () {
    throw ManageException::build()
        ->log()->info()->b()
        ->desc()->not('API')->found()->b()
        ->fill();
});
