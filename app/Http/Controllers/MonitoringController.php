<?php

namespace App\Http\Controllers;

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
