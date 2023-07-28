<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GreetingsController extends Controller
{
    public function hello(Request $request): array
    {
        $res = [
            'greeting' => 'Hello'
        ];
        if ($request->has('name')) {
            $res['greeting'] .= ' ' . $request->get('name');
        }

        return $res;
    }
}
