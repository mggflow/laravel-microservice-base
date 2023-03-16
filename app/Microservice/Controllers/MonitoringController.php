<?php

namespace App\Microservice\Controllers;


use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    /**
     * Check that service is alive.
     * @return array
     */
    public function ping(): array
    {
        return [
            'alive' => true,
            'elapsed' => microtime(true) - LARAVEL_START,
        ];
    }
}
