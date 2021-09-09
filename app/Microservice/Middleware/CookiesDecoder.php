<?php

namespace App\Microservice\Middleware;


use Closure;
use Illuminate\Http\Request;

class CookiesDecoder
{
    /**
     * Names of cookies for json decode.
     *
     * @var array
     */
    protected array $json = [

    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->decodeSomeRequestCookies($request);

        return $next($request);
    }

    /**
     * Decode Request cookies by keys.
     *
     * @param Request $request
     */
    protected function decodeSomeRequestCookies(Request $request)
    {
        foreach ($this->json as $key) {
            if ($request->cookies->has($key)) {
                $cookie = $request->cookies->get($key);
                if (empty($cookie)) continue;
                $cookie = json_decode($request->cookies[]);

                $request->cookies->set(
                    $key, $cookie
                );
            }
        }
    }
}
