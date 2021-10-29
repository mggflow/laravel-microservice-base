<?php

namespace App\Microservice\Middleware;

use Closure;
use Illuminate\Http\Request;

class Preparation
{
    /**
     * Fill in a request with service information.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->provideMicroserviceMeta($request);

        return $next($request);
    }

    /**
     * Provide request microservice metadata.
     *
     * @param Request $request
     */
    protected function provideMicroserviceMeta(Request $request)
    {
        $toMerge = $this->parseObjectAndAction($request->path());

        if ($request->missing('msvc')) {
            $toMerge['msvc'] = $request->route('microserviceName', env('MICROSERVICE_NAME'));
        }

        $request->merge($toMerge);
    }

    /**
     * Parse request object and action.
     *
     * @param string $path
     * @return array
     */
    protected function parseObjectAndAction(string $path): array
    {
        $parsed = [
            'msvc_object' => false,
            'msvc_action' => false,
            'msvc_authenticated' => false,
        ];

        $withoutUriPrefix = mb_stristr($path, 'api/');
        if ($withoutUriPrefix === false) return $parsed;

        $parts = explode('/', $withoutUriPrefix);
        $parsed['msvc_action'] = array_pop($parts);

        $parts = array_slice($parts, 2);
        $parsed['msvc_object'] = join('/', $parts);

        return $parsed;
    }
}
