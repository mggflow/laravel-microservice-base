<?php

namespace App\Microservice\Controllers;


class MonitoringController extends \App\Http\Controllers\Controller
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
