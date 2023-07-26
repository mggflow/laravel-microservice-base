<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Auto reset cache for views in dev environment
if (config('app.env', 'prod') != 'prod') {
    Artisan::call('view:clear');
}

Route::get('/', function () {
    return \Illuminate\Support\Facades\Response::make(config('app.name').' is available.');
});
