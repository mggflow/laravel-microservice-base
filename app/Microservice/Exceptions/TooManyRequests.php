<?php

namespace App\Microservice\Exceptions;

class TooManyRequests extends MicroserviceException
{
    protected $message = 'Too many requests';
    protected $code = 4;
}
