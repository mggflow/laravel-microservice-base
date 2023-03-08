<?php

namespace App\Microservice\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

class BasicValidation
{
    /**
     * Rules of basic validation.
     *
     * @var array
     */
    protected array $rules = [
        'msvc' => ['required', 'string', 'max:32'],
        'msvc_access_key' => ['alpha_num', 'max:64'],
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws UniException
     */
    public function handle(Request $request, Closure $next)
    {
        $this->validateRequestData($request->all());

        return $next($request);
    }

    /**
     * @param array $data
     * @throws UniException
     */
    protected function validateRequestData(array $data)
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->failed('Basic Validation')->b()
                ->fill();
        }
    }
}
