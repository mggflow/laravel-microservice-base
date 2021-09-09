<?php

namespace App\Microservice\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Example of action with request content
     *
     * @param Request $request
     * @return array
     */
    public function hello(Request $request): array
    {
        $result = array_merge([
            'message' => 'Hello World',
            'elapsed' => microtime(true) - LARAVEL_START,
        ], $request->all());

        return $result;
    }
}
