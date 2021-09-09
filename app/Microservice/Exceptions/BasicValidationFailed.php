<?php

namespace App\Microservice\Exceptions;

class BasicValidationFailed extends MicroserviceException
{
    protected $message = 'Basic validation failed';
    protected $code = 2;
}
