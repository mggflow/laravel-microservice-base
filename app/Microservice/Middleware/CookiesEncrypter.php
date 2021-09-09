<?php

namespace App\Microservice\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class CookiesEncrypter extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [

    ];
}
