<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use MGGFLOW\LVMSVC\Exceptions\MakeErrorsResponseContent;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (RouteServiceProvider::isApiRoute()) {
            return Response::json(MakeErrorsResponseContent::make($e));
        }

        return parent::render($request, $e);
    }
}
