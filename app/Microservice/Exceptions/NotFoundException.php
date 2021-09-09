<?php

namespace App\Microservice\Exceptions;

class NotFoundException extends MicroserviceException
{
    protected $message = 'API not found';
    protected $code = 1;
}
