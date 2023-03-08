<?php

use Illuminate\Support\Facades\Route;
use MGGFLOW\ExceptionManager\ManageException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Route scheme is: https://site.com/ api [api routes group] / {microservice name} / ... / {object name} / ... / {action name} .
 */

/**
 * Routes microservice API.
 */
Route::prefix('{microserviceName}')->group(function (){
    Route::prefix('monitoring')->group(function (){
        Route::any('ping','MonitoringController@ping');
    });

    Route::any('hello','MainController@hello');
});


/**
 * API 404 handling.
 */
Route::fallback(function (){
    throw ManageException::build()
        ->log()->info()->b()
        ->desc()->not('API')->found()->b()
        ->fill();
});
