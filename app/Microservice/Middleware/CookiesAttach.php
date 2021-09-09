<?php

namespace App\Microservice\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CookiesAttach
{

    /**
     * Cookie facade.
     *
     * @var Cookie
     */
    protected Cookie $cookiesFacade;

    public function __construct(Cookie $cookiesFacade)
    {
        $this->cookiesFacade = $cookiesFacade;
    }

    /**
     * Handle response.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $this->attachCookiesToResponse($response);

        return $response;
    }

    /**
     * Attach cookies to Response.
     *
     * @param Response
     */
    protected function attachCookiesToResponse($response)
    {
        $cookies = $this->cookiesFacade::getQueuedCookies();

        foreach ($cookies as $cookie) {
            $response->withCookie($cookie);
        }
    }
}
