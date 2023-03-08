<?php

namespace App\Exceptions;

use App\Microservice\Exceptions\MakeErrorsResponseContent;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        UniException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($this->isApiRoute()){
            return MakeErrorsResponseContent::make($e);
        }

        return parent::render($request, $e);
    }

    protected function isApiRoute(): bool
    {
        $route = Route::current();
        if (empty($route)) return false;
        $uri = $route->uri();
        $prefix = env('ROOT_PREFIX');

        $expectedStart = ltrim(trim($prefix, '/') . '/api/', '/');

        $matchPos = stripos($uri, $expectedStart);

        return $matchPos !== false and $matchPos < 2;
    }
}
