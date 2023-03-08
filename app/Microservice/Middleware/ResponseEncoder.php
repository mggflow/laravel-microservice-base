<?php

namespace App\Microservice\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseEncoder
{
    /**
     * The Response Factory our app uses.
     *
     * @var ResponseFactory
     */
    protected ResponseFactory $factory;

    /**
     * ResponseEncoder constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }


    /**
     * Encode response as JSON.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (is_array($response)
            or is_scalar($response)
            or is_null($response)
        ) {
            $response = $this->factory->json($response);
        } elseif (!$response instanceof JsonResponse) {
            $response = $this->factory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;

    }
}
