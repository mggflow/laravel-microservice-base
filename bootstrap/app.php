<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Response;
use MGGFLOW\LVMSVC\Exceptions\MakeErrorsResponseContent;
use MGGFLOW\LVMSVC\Middleware\BasicValidation;
use MGGFLOW\LVMSVC\Middleware\CookiesAttach;
use MGGFLOW\LVMSVC\Middleware\CookiesDecoder;
use MGGFLOW\LVMSVC\Middleware\CookiesEncryption;
use MGGFLOW\LVMSVC\Middleware\MsvcAuthentication;
use MGGFLOW\LVMSVC\Middleware\ResponseEncoder;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            'signed' => \App\Http\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

            'msvc_validation' => BasicValidation::class,
            'msvc_auth' => MsvcAuthentication::class,
            'msvc_response_encoder' => ResponseEncoder::class,
            'msvc_cookies_encrypter' => CookiesEncryption::class,
            'msvc_cookies_handler' => CookiesAttach::class,
            'msvc_cookies_decoder' => CookiesDecoder::class,
        ]);

        $middleware->use([
            // \App\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            'bindings',
        ]);

        $middleware->group('api', [
            'throttle:api',
            'msvc_cookies_encrypter',
            'msvc_cookies_decoder',
            'msvc_cookies_handler',
            'msvc_response_encoder',
            'msvc_validation',
            'msvc_auth',
            'bindings',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            if (RouteServiceProvider::isApiRoute()) {
                return Response::json(MakeErrorsResponseContent::make($e));
            }
        });
    })->create();
