<?php

namespace App\Microservice\Exceptions;

class MakeErrorsResponseContent
{
    public static function make(?\Throwable $e = null): array
    {
        return ['errors' => MakeErrorsRender::make($e)];
    }
}
