<?php

namespace App\Microservice\Exceptions;

class MethodValidation extends MicroserviceException
{
    protected $message = 'Method validation failed';
    protected $code = 3;
}
