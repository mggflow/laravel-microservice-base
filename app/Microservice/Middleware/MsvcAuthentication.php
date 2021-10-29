<?php

namespace App\Microservice\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsvcAuthentication
{
    /**
     * Name of service connection
     *
     * @var string
     */
    protected string $connectionName = 'msvc';
    /**
     * Table name for microservices map table
     *
     * @var string
     */
    protected string $accessTableName = 'access';
    /**
     * Database facade.
     *
     * @var DB
     */
    protected DB $db;

    /**
     * Current Microservice name
     *
     * @var string
     */
    protected string $currentMsvcName;

    /**
     * Request key of microservice access key
     *
     * @var string
     */
    protected string $msvcRequestAccessKey = 'msvc_access_key';

    /**
     * Mapping constructor.
     *
     * @param DB $dbFacade
     */
    public function __construct(DB $dbFacade)
    {
        $this->db = $dbFacade;

        $this->currentMsvcName = env('MICROSERVICE_NAME', 'msvc');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestAccessKey = $this->parseAccessKey($request);

        if($requestAccessKey){
            $selfAccessKey = $this->getSelfAccessKey();
            $this->provideAuthenticated($requestAccessKey,$selfAccessKey,$request);
        }


        return $next($request);
    }

    /**
     * Parse access key from request
     *
     * @param Request $request
     * @return mixed
     */
    protected function parseAccessKey(Request $request){
        return $request->input($this->msvcRequestAccessKey,false);
    }

    /**
     * Find microservice Access key in DB
     *
     * @return false|mixed
     */
    protected function getSelfAccessKey(){
        $access = $this->db::connection($this->connectionName)->table($this->accessTableName)
            ->where('name', '=', $this->currentMsvcName)
            ->first();

        if(empty($access)) return false;

        return $access->access_key;
    }

    /**
     * Set authenticated state if keys equal
     *
     * @param $requestAccessKey
     * @param $selfAccessKey
     * @param Request $request
     */
    protected function provideAuthenticated($requestAccessKey,$selfAccessKey,Request $request){
        if($selfAccessKey and $requestAccessKey==$selfAccessKey){
            $request->merge(['msvc_authenticated'=>true]);
        }
    }


}
